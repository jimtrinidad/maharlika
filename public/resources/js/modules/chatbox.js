function Chatbox() {

    // because this is overwritten on jquery events
    var self = this;

    this.from_delivery_notif = false;

    this.isTabActive = true;
    this.currentUser;
    this.totalUnread = 0;
    this.totalMsg = 0;
    this.participantCount = 0;
    this.threads = {};
    this.activeThread;
    this.lastTime = 0;
    this.activeRequest = [];
    this.readRequest;
    this.findRequest;
    this.threadRequest;
    this.receiverID;
    this.threadType;
    this.serviceID;
    this.new_support_thread = false;
    this.textarea;

    /**
     * Initialize events
     */
    this._init = function() 
    {

        self.set_events();
        self.set_configs();
        self.getThreads();
        self.userFinder("#findUser");
        self.userFinderMulti('#findManyUser');

        self.currentUser = $('#chat_current_user').val();
    }

    /**
    * events delaration
    */
    this.set_events = function()
    {

        window.onfocus = function () { 
          self.isTabActive = true; 
        }; 

        window.onblur = function () { 
          self.isTabActive = false; 
        }; 

        $(window).focus(function() {
            self.isTabActive = true; 
        });

        $(window).blur(function() {
            self.isTabActive = false; 
        });

        var dragged     = false;
        var $draggable  = $('.chatbubble .unexpanded').draggabilly({
            containment: 'body'
        });

        $draggable.on( 'dragStart', function( event, pointer ) {
            dragged = true;
        });

        $draggable.on( 'dragEnd', function( event, pointer ) {
            setTimeout(function(){
                dragged = false;
            }, 100)
        })

        $('.chatbubble .unexpanded').click(function(e){
            if (!dragged) {
                self.openChatWindow();
            }
        });

        $('.chatbubble .close-chat').click(function(){
            $('.chatbubble').removeClass('opened');
            $(".chatbubble .list-friends").hide();
            $(".chatbubble .messages").hide();

            self.abortRequest();
            if (self.readRequest) {
                self.readRequest.abort();
            }
            if (self.findRequest) {
                self.findRequest.abort();
            }

            self.unlockBodyScroll();

            if (self.from_delivery_notif) {
                $('#neworderModal').modal('show');
                self.from_delivery_notif = false;
            }
        });

        // select thread
        $('.chatbubble .recent-threads').on('click', 'li', function(){
            self.selectThread(this);
        });

        // select friend
        $('.chatbubble .connection-list').on('click', 'li', function(){
            self.selectFriend(this);
        });

        $('.chatbubble .top').on('click', '.manage_group', function(){
            self.manageGroup(this);
        });

        // new or find thread
        $('.chatbubble .new-message').click(function(){
            self.clearThread();
        });

        // send message via enter
        $("#findUser").keypress(function(e) {
          if (e.keyCode === 13) {
            self.findThreadByID($("#findUser").val());
            return false;
          }
        });

        $("#findManyUser").keypress(function(e) {
          if (e.keyCode === 13) {
            if ($('.findManyUserGroup').find('.ttmulti-selections li').length > 0) {
                $('.no-selected-user').hide();
            }
          }
        });
        $("#startGroupChat").click(function(e) {
            var selected = [];
            var selected_el = $('.findManyUserGroup').find('.ttmulti-selections li');
            if (selected_el.length > 0) {
                $.each(selected_el, function(i,e) {
                    selected.push($(e).data('val'));                    
                });
                if (selected.length > 1) {
                    self.findThreadByID(selected, 2);
                } else {
                    // only 1, use private message
                    self.findThreadByID(selected[0]);
                }
                $('.no-selected-user').hide();
            } else {
                $('.no-selected-user').show();
            }
        });

        // send message via enter
        $("#text_message").keypress(function(e) {
            if ($(".chatbubble .write-form").hasClass('sending')) {
                // disable write when sending
                return false;
            }
            if (e.keyCode === 13) {
                self.sendMessage();
                return false;
            }
        });

        // send message via click
        $(".chatbubble .send").click(function() {
            self.sendMessage();
        });

        $("#group_name").keypress(function(e) {
          if (e.keyCode === 13) {
            self.saveGroupAlias(this);
            return false;
          }
        });

        $('#manageGroupModal #addFoundUserForGroup').click(function(){
            self.addGroupMember(this);
        });

        $('#manageGroupModal .leave_group').click(function(){
            self.leaveGroup(this);
        });

        $('#manageGroupModal').on('click', '.kick_participant', function(){
            self.kickParticipant(this);
        });

        $('#manageGroupModal #groupImageForm').submit(function(e) {
            e.preventDefault();
            self.saveGroupImage(this);
        }) 

    }

    /**
    * usage of different libraries and plugins
    */
    this.set_configs = function()
    {

        // BLOCK BODY SCROLL WHEN FOCUSED ON CHATBOX
        $chatbubble = $('.chatbubble .expanded');
        $chatbubble.mouseenter(function(){
            setTimeout(function(){
                self.lockBodyScroll();
            }, 100);
        }).mouseleave(function(e){
            $('body').one('mousemove', function(evt){
                if($(evt.target).prop('class') != 'loadingoverlay') {
                    setTimeout(function(){
                        self.unlockBodyScroll();
                    }, 100);
                }
            });
        });

        self.setScroll();

        $(window).resize(function(){
            self.resetScroll();
        });

        setInterval(function(){
            if ($('.chatbubble').hasClass('opened') && self.activeThread && self.isTabActive) {
                var thread_data = self.get_thread_data(self.activeThread);
                if (thread_data.unread > 0) {
                    self.setRead(self.activeThread);
                }
            }
        }, 3000);


        self.textarea = $('#text_message').emojioneArea({
            pickerPosition: "top",
            filtersPosition: "bottom",
            tones: false,
            autocomplete: false,
            hidePickerOnBlur: true,
            shortnames: true,
            saveEmojisAs: 'shortname',
            search: true,
            searchPosition: "bottom",
            events: {
                keydown: function (editor, event) {
                    if(event.which == 13){
                        self.sendMessage(); // work
                        self.textarea.data("emojioneArea").setText(''); // this work
                    }
                }
            }
        });

    }

    this.lockBodyScroll = function()
    {
        // console.log('focused');
        var scrollTop = $('html').scrollTop() ? $('html').scrollTop() : $('body').scrollTop(); // Works for Chrome, Firefox, IE..
        // console.log(scrollTop);
        $('html').addClass('noscroll');
        if (scrollTop != 0) {
            $('html').css('top',-scrollTop);
        }
    }

    this.unlockBodyScroll = function()
    {
        // console.log('blured');  
        var scrollTop = parseInt($('html').css('top'));
        // console.log('v -' + scrollTop);
        $('html,body').removeClass('noscroll');
        if (scrollTop != 0) {
            $('html,body').scrollTop(-scrollTop);
        }
    }

    this.setScroll = function()
    {
        $(".chatbubble .recent-threads").niceScroll({
            cursorcolor: "#696c75",
            cursorwidth: "4px",
            cursorborder: "none"
        });

        $(".chatbubble .connection-list").niceScroll({
            cursorcolor: "#696c75",
            cursorwidth: "4px",
            cursorborder: "none"
        });

        $(".chatbubble .messages").niceScroll({
            cursorcolor: "#cdd2d6",
            cursorwidth: "4px",
            cursorborder: "none"
        });
    }

    this.resetScroll = function()
    {   
        // console.log($(".chatbubble .messages").getNiceScroll(),$(".chatbubble .list-friends").getNiceScroll());
        // $(".chatbubble .messages").getNiceScroll(0).remove();
        // $(".chatbubble .recent-threads").getNiceScroll(0).remove();

        if ($(".chatbubble").height() > 500) {
            $(".chatbubble .list-friends").height(470);
            $(".chatbubble .connection-list").height(500);
            $(".chatbubble .messages").height(396);
        } else {
            $(".chatbubble .list-friends").height(170);
            $(".chatbubble .connection-list").height(200);
            $(".chatbubble .messages").height(162);
        }
        setTimeout(function(){
            $(".chatbubble .messages").getNiceScroll(0).resize();
            $(".chatbubble .recent-threads").getNiceScroll(0).resize();
            $(".chatbubble .connection-list").getNiceScroll(0).resize();
        }, 100)
    }

    this.openChatWindow = function(tab = false)
    {
        $('.chatbubble').addClass('opened');
        $(".chatbubble .list-friends").show();
        $(".chatbubble .messages").show();

        if (tab != false) {
            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        } else {
            $('a[data-toggle="tab"]:last').tab('show');
        }

        self.resetScroll();
    }

    this.clearResizeScroll = function() {
        $(".chatbubble .messages").getNiceScroll(0).resize();
        $(".chatbubble .messages").getNiceScroll(0).doScrollTop(999999, 999);
    };


    /**
    * send message request from outside
    * called from other pages, not within chatbox
    */
    this.openChatbox = function(ID)
    {

        // hide delivery notif
        if (self.from_delivery_notif) {
            $('#neworderModal').modal('hide');
        }

        self.abortRequest();
        self.activeThread = false;
        self.receiverID = false;
        $('.chatbubble').addClass('opened');
        $(".chatbubble .list-friends").show();
        $(".chatbubble .messages").show();
        $('.chatbubble .recent-threads li').removeClass('active');
        self.findThreadByID(ID);

        // open recent tab
        $('a[data-toggle="tab"]:last').tab('show');

        setTimeout(function(){
            self.lockBodyScroll();
        }, 100);
    }

    /**
    * get thread from fetched data
    */
    this.get_thread_data = function(id)
    {
        var match = false;
        $.each(self.threads, function(i,e){
            if (e.id == id) {
                match = e;
                return false;
            }
        });
        return match;
    }

    /**
    * poll threads
    */
    this.getThreads = function(callback = false)
    {
        if (self.threadRequest) {
            self.threadRequest.abort();
        }
        self.threadRequest = $.ajax({
            url  : window.base_url('message/threads'),
            type : 'get',
            data : {'unread': self.totalUnread, 'count': self.totalMsg, 'parti_count': self.participantCount},
            success : function(response) {
                if (response.status) {

                    var old_active_thread = self.get_thread_data(self.activeThread);

                    self.totalUnread = response.unread;
                    self.totalMsg = response.count;
                    self.participantCount = response.parti_count;
                    self.threads = response.data;
                    self.showThreads(response.data);

                    if (self.totalUnread > 0) {
                        $('span.bubble-unread').text(self.totalUnread).removeClass('hide');
                    } else {
                        $('span.bubble-unread').addClass('hide');
                    }

                    // on thread refresh, and the active thread is not on the new list if thread, user was kicked!
                    if (old_active_thread && !self.get_thread_data(self.activeThread)) {
                        bootbox.alert('You had been kicked out of "<b class="text-bold">' + old_active_thread.name + '</b>" group.');
                        self.clearThread();
                    }
                }
            },
            complete: function(a, b) {
                if (b != 'abort') {
                    setTimeout(function(){
                        self.getThreads();
                    }, 1000);
                }

                if (callback) {
                    callback();
                }
            }
        });
    }

    /**
    * poll messages
    */
    this.getMessages = function(read = 0, callback = false)
    {   

        // cancel previous request first
        self.abortRequest();

        $request = $.ajax({
            url  : window.base_url('message/messages'),
            type : 'get',
            data : {
                'thread_id': self.activeThread,
                'timestamp': self.lastTime,
                'read': read
            },
            success : function(response) {
                if (response.status) {
                    self.lastTime = response.timestamp;
                    self.showMessages(response.data);
                }
            },
            complete: function(a, b) {
                if (b != 'abort') {
                    setTimeout(function(){
                        self.getMessages();
                    }, 1000);
                }

                if (callback) {
                    callback();
                }
                $(".chatbubble .messages").LoadingOverlay("hide");
            }
        });

        self.activeRequest.push($request);
    }

    /**
    * send message
    */
    this.sendMessage = function()
    {
        // var message = $("#text_message").val();
        var message = self.textarea.data("emojioneArea").getText().trim();
        if (message) {

            $(".chatbubble .write-form").LoadingOverlay("show", {zIndex: 9999999});
            if (!$(".chatbubble .write-form").hasClass('sending')) {
                $(".chatbubble .write-form").addClass('sending');
                $("#text_message").blur();

                var vData = {
                        'message': message
                    };
                if (self.activeThread) {
                    vData.thread_id = self.activeThread;
                } else if (self.receiverID) {
                    vData.receiver = self.receiverID;
                    vData.thread_type = self.threadType;
                }

                $.ajax({
                    url  : window.base_url('message/send'),
                    type : 'get',
                    data : vData,
                    success : function(response) {
                        if (response.status) {
                            if (response.type == 2 || response.type == 3) {

                                // set new message as active thread
                                self.activeThread = response.data;
                                self.lastTime = 0

                                $('.nav-tabs a[href="#recent"]').tab('show');

                                // refresh thread
                                self.getThreads(function(){
                                    $('#thread_' + response.data).removeClass('active').click();
                                });
                                
                            } else {
                                self.lastTime = response.timestamp;

                                messageData = {
                                    cdate: response.datetime,
                                    sender_id: self.currentUser,
                                    user_name: 'Me',
                                    body: message,
                                    id: response.data
                                }

                                self.showMessages([messageData]);
                            }

                            // abort previous message request, request new with latest timestamp
                            self.getMessages();

                            $(".chatbubble .write-form .textMessageHelp").text('');

                        } else {
                            $(".chatbubble .write-form .textMessageHelp").text(response.message);
                        }
                    }, complete: function() {
                        $(".chatbubble .write-form").removeClass('sending');
                        $(".chatbubble .write-form").LoadingOverlay("hide");
                        $("#text_message").focus();

                        $("#text_message").val('');
                        self.textarea.data("emojioneArea").setText('')
                        self.textarea.data("emojioneArea").hidePicker();
                    }
                });
            }
        }
    }

    /**
    * mark as read
    */
    this.setRead = function(thread_id) {

        if (!self.readRequest) {
            self.readRequest = $.ajax({
                url  : window.base_url('message/read'),
                type : 'get',
                data : {'thread_id' : thread_id}
            });
            self.readRequest = false;
        }
    }

    /**
    * abort active request
    */
    this.abortRequest = function()
    {
        $.each(self.activeRequest, function(i,r){
            r.abort();
            self.activeRequest.splice(i, 1);
        });
    }

    /**
    * clear messages, show user finder
    */
    this.clearThread = function()
    {
        self.abortRequest();
        $('.chatbubble .top .info .name').text('');
        $('.chatbubble .top .info .count').text('');
        $('.chatbubble .top content').addClass('hide');
        $('.chatbubble .write-form').addClass('hide');
        $('.chatbubble .messages').html('').addClass('hide');
        $('.chatbubble .recent-threads li').removeClass('active');
        $('#findUser, #findManyUser').val('');
        $('.findUserGroup, .findManyUserGroup').removeClass('has-error');
        $('.findUserGroup .findUserHelp').text('Press enter to start conversation.');
        $('.findManyUserGroup .findUserHelp').text('Press enter to add to group.');
        $('.chatbubble .finder').removeClass('hide');

        $("#text_message").val('');
        self.textarea.data("emojioneArea").setText('');

        self.activeThread = false;
        self.receiverID = false;

        self.userFinder("#findUser");
        self.userFinderMulti('#findManyUser');
    }


    /**
    * find conversation by user id
    */
    this.findThreadByID = function(userID, type = 0)
    {
        if (self.findRequest) {
            self.findRequest.abort();
            $('.chatbubble .finder').LoadingOverlay('hide');
        }

        $('.chatbubble .finder').LoadingOverlay('show', {zIndex: 999999});
        self.findRequest = $.ajax({
                url  : window.base_url('message/find'),
                type : 'get',
                data : {
                    'public_id'  : userID,
                    'type'       : type
                },
                success: function(response) {
                    if (response.status) {

                        console.log(response);

                        if (response.code == 2 && $('#thread_' + response.thread_id).length) {
                            // if type is group, and same participants exists, ask if want to use it or create a new group
                            if (type == 2) {
                                bootbox.confirm({
                                    message: 'Group with the same participants already exist. Do you want to use it or create a new group.',
                                    buttons: {
                                        confirm: {
                                            label: 'Use existing',
                                            className: 'btn-danger'
                                        },
                                        cancel: {
                                            label: 'Create a new one',
                                            className: 'btn-success',
                                        }
                                    },
                                    callback: function (result) {
                                        if (!result) {
                                            // set info
                                            $('.chatbubble .top .avatar img').prop('src', window.public_url('assets/profile/' + response.receiver.photo));
                                            $('.chatbubble .top .info .name').text(response.receiver.name);
                                            $('.chatbubble .top .info .count').text('new conversation');
                                            $('.chatbubble .top content').removeClass('hide');
                                            $('.chatbubble .write-form').removeClass('hide');
                                            $('.chatbubble .messages').html('').removeClass('hide');

                                            self.receiverID = response.receiver.id;
                                            self.threadType = type;
                                        } else {
                                            $('#thread_' + response.thread_id).click();
                                        }
                                    }
                                })
                            } else {
                                $('#thread_' + response.thread_id).click();
                            }

                        } else {
                            // set info
                            $('.chatbubble .top .avatar img').prop('src', window.public_url('assets/profile/' + response.receiver.photo));
                            $('.chatbubble .top .info .name').text(response.receiver.name);
                            $('.chatbubble .top .info .count').text('new conversation');
                            $('.chatbubble .top content').removeClass('hide');
                            $('.chatbubble .write-form').removeClass('hide');
                            $('.chatbubble .messages').html('').removeClass('hide');

                            self.receiverID = response.receiver.id;
                            self.threadType = type;
                        }

                        $('.chatbubble .finder').addClass('hide');
                        $('.' + (type == 2 ? 'findManyUserGroup' : 'findUserGroup')).removeClass('has-error');
                    } else {
                        $('.' + (type == 2 ? 'findManyUserGroup' : 'findUserGroup')).find('.findUserHelp').text(response.message);
                        $('.' + (type == 2 ? 'findManyUserGroup' : 'findUserGroup')).addClass('has-error');
                    }
                },
                complete: function() {
                    self.findRequest = false;
                    $('.chatbubble .finder').LoadingOverlay('hide');
                }
            });
    }

    /**
    * generate recent list items
    */
    this.showThreads = function(data)
    {
        var recent_holder = $('menu.recent-threads');
        recent_holder.html('');
        $.each(data, function (i,e){
            var recentImg = e.photo;
            var recentName = e.name;
            var recentNote = e.msg_count + ' messages';
            var badge = '';
            if (e.unread > 0) {
                recentNote = '<span class="badge badge-danger">'+e.unread + '</span> new messages';
                badge = '<span class="notif_badge badge badge-danger">'+e.unread + '</span>';
            }
            var isactive = '';
            if (e.id == self.activeThread) {
                isactive = 'active';
                $('.chatbubble .top .info .count').text(e.msg_count + ' messages found');
            }
            recent_holder.append(
                '<li id="thread_'+e.id+'" class="'+isactive +'" data-thread_id="'+e.id+'"> \
                    <img width="40" height="40" src="'+recentImg+'" title="'+recentName+'"> \
                    <span class="xs-only">'+badge+'</span> \
                    <div class="info"> \
                        <div class="user">'+recentName+'</div> \
                        <div class="status">'+recentNote+'</div> \
                    </div> \
                </li>'
            );
        });
    }

    /**
    * select thread
    */
    this.selectThread = function(elem)
    {
        var $this = $(elem);
        if (!$this.hasClass('active')) {
            var data = self.get_thread_data($this.data('thread_id'));
            $('.chatbubble menu li').removeClass('active');
            $this.addClass('active');

            // set info
            $('.chatbubble .top .avatar img').prop('src', data.photo);
            var participants = [];
            $.each(data.participants, function(i, e) {
                participants.push(e.user_name);
            });
            if (data.type == 2) {
                $('.chatbubble .top .info .name').html('<span>' + data.name + `</span> <a href="javascript:;" class="manage_group small" data-thread_id="${data.id}"><i class="fa fa-cog"></i>Manage</a>`);
            } else {
                $('.chatbubble .top .info .name').text(data.name);
            }
            $('.chatbubble .top .info .count').text(data.msg_count + ' messages found');
            $('.chatbubble .top content').removeClass('hide');
            $('.chatbubble .write-form').removeClass('hide');
            
            $(".chatbubble .write-form .textMessageHelp").text('');
            $(".chatbubble .finder").addClass('hide');
            $(".chatbubble .messages").html('').removeClass('hide').LoadingOverlay("show", {zIndex: 9999999});

            $("#text_message").val('');
            self.textarea.data("emojioneArea").setText('');

            self.receiverID = false;
            self.activeThread  = data.id;
            self.lastTime = 0;
            self.getMessages(1);
        }
    }

    this.selectFriend = function(elem)
    {
        var $this = $(elem);
        if (!$this.hasClass('active')) {
            var data = $(elem).data();

            $('.chatbubble menu li').removeClass('active');
            $this.addClass('active');

            // set info
            $('.chatbubble .top .avatar img').prop('src', $this.find('img').prop('src'));
            $('.chatbubble .top .info .name').text($this.find('.user').text());
            $('.chatbubble .top .info .count').text('');
            $('.chatbubble .top content').removeClass('hide');
            $('.chatbubble .write-form').removeClass('hide');
            
            $(".chatbubble .write-form .textMessageHelp").text('');
            $(".chatbubble .finder").addClass('hide');
            $(".chatbubble .messages").html('').removeClass('hide');

            self.receiverID = false;
            self.serviceID  = data.code;
            self.activeThread  = data.thread_id;
            self.lastTime = 0;

            self.openChatbox(data.id);
        }
    }


    /**
    * show messages
    */
    this.showMessages = function(data)
    {

        $.each(data, function(i, e){
            
            if (!$(".chatbubble .messages").find('#msg_id_' + e.id).length) {
                var ctime   = moment(e.cdate).fromNow();
                var body    = emojione.shortnameToImage(e.body);
                var notext  = ($('<span>' + body + '<span>').text().trim() == '' ? 'notext' : '');
                if (e.sender_id == self.currentUser) {
                    $(".chatbubble .messages").append(
                        `<li class="i" id="msg_id_${e.id}">
                            <div class="head">
                                <span class="time">${ctime}</span>
                                <span class="name">Me</span>
                            </div>
                            <div class="message ${notext}">${body}</div>
                        </li>`
                    );
                } else {
                    $(".chatbubble .messages").append(
                        `<li class="friend" id="msg_id_${e.id}">
                            <div class="head">
                                <span class="name">${e.user_name}</span>
                                <span class="time">${ctime}</span>
                            </div>
                            <div class="message ${notext}">${body}</div>
                        </li>`
                    );
                }
                self.clearResizeScroll();
            }
        })
    }

    this.userFinder = function(elem)
    {   
        try { $(elem).typeahead('destroy'); } catch(e) {}
        $(elem).typeahead({
            hint: false,
            minLength: 5,
        },
        {
            templates: {
                empty: [
                    '<div class="padding-left-10 empty-message">',
                      'No match found.',
                    '</div>'
                ].join('\n'),
                suggestion: function (item) {
                    item.address.pop();
                    console.log(item);
                    return '<div><div class="row gutter-5">' +
                                '<div class="col-2">' +
                                    '<span>' +
                                    '<img style="width:45px;height:45px;margin: 0 auto;" src="' + window.public_url() + "assets/profile/"+item.photo+'">' +
                                    '</span></div>' +
                                '<div class="col-10 small" style="padding-left: 10px;">' +
                                    '<div>'+ item.publicID + '</div>' +
                                    '<div>'+ item.fullname +'</div>' +
                                '</div>' +
                            '</div></div>';
                }
            },
            name: 'user',
            display: 'publicID',
            source: function(query, syncResults, asyncResults) {
                try {clearTimeout(typeaheadTimeout);} catch (e) {}
                typeaheadTimeout = setTimeout(function (){
                    $.get(window.base_url('message/find_user') + "?q=" + query, function(responseData) {
                        asyncResults(responseData);
                    });
                }, 500);
            }
        }).bind('typeahead:select', function(ev, item) {
            var id = $(ev.target).prop('id');
        });

    },

    this.userFinderMulti = function(elem)
    {   
        
        $('.no-selected-user').hide();
        // if already set, clear selected
        if ($('.findManyUserGroup').find('.ttmulti-selections').length > 0) {
            $('.findManyUserGroup').find('.ttmulti-selections').html('');
        } else {
            $(elem).typeaheadmulti({
                hint: false,
                minLength: 5
            },
            {
                templates: {
                    empty: [
                        '<div class="padding-left-10 empty-message">',
                          'No match found.',
                        '</div>'
                    ].join('\n'),
                    suggestion: function (item) {
                        item.address.pop();
                        return '<div><div class="row gutter-5">' +
                                    '<div class="col-2">' +
                                        '<span>' +
                                        '<img style="width:45px;height:45px;margin: 0 auto;" src="' + window.public_url() + "assets/profile/"+item.photo+'">' +
                                        '</span></div>' +
                                    '<div class="col-10 small" style="padding-left: 10px;">' +
                                        '<div>'+ item.publicID + '</div>' +
                                        '<div>'+ item.fullname +'</div>' +
                                    '</div>' +
                                '</div></div>';
                    }
                },
                name: 'user',
                display: 'publicID',
                source: function(query, syncResults, asyncResults) {
                    try {clearTimeout(typeaheadTimeout);} catch (e) {}
                    typeaheadTimeout = setTimeout(function (){
                        $.get(window.base_url('message/find_user') + "?q=" + query, function(responseData) {
                            asyncResults(responseData);
                        });
                    }, 500);
                }
            });
        }
    }

    this.manageGroup = function(elem)
    {
        var $this = $(elem);
        var data = self.get_thread_data($this.data('thread_id'));
        // console.log(data);

        $('#findUserForGroup').val('');
        self.userFinder("#findUserForGroup");
        $('#manageGroupModal .modal_thread_id').val(data.id);
        $('#manageGroupModal .image-preview').prop('src', $('.chatbubble .top .avatar img').prop('src'));
        $('#manageGroupModal #group_name').val($('.chatbubble .top .info .name span').text());
        $('#manageGroupModal .participant-list').html('');
        $.each(data.participants, function(i,e) {
            var kicklink = '';
            if (data.starter == self.currentUser) {
                kicklink = `<i class="js-remove kick_participant pull-right" data-user="${e.user_id}" style="cursor:pointer">✖</i>`;
            }
            var tpl = `<li class="ttmulti-selection list-group-item padding-5">
                        <img width="30" height="30" style="vertical-align: middle;" src="${window.public_url() + "assets/profile/"+e.Photo}">
                        <span>${e.user_name}</span>
                        ${kicklink}
                    </li>`;

            $('#manageGroupModal .participant-list').append(tpl);
        });
        
        $('#manageGroupModal').modal({
            backdrop : 'static',
            keyboard : false
        });
    }

    this.saveGroupAlias = function(elem)
    {
        var $this = $(elem);
        var thread_id = $('#manageGroupModal #modal_thread_id').val();
        var data = self.get_thread_data(thread_id);
        $('#manageGroupModal .modal-content').LoadingOverlay("show", {zIndex: 9999999});
        $.ajax({
            url  : window.base_url('message/savegroupalias'),
            type : 'get',
            data: {
                'thread_id' : thread_id,
                'alias'     : $this.val()
            },
            success : function(response) {
                if (response.status) {
                    if ($this.val() == '') {
                        var name = data.name;
                    } else {
                        var name = $this.val();
                    }
                    $('.chatbubble .top .info .name span').text(name);
                    $('#thread_' + thread_id).find('.user').text(name);
                }
            },
            complete: function(r) {
                $('#manageGroupModal .modal-content').LoadingOverlay("hide");
            }
        });
    }

    this.saveGroupImage = function(form)
    {
        // prenvet multiple calls
        if ($(form).data('running')) {
            return false;
        }

        $(form).data('running', true);
        $(form).find('input').blur();
        $(form).LoadingOverlay("show");

        Utils.append_csrf_token(form);
        var formData = new FormData(form);
        var thread_id = $('#manageGroupModal #modal_thread_id').val();
        
        // reset input erros
        $.each($(form).find('input, select, textarea'), function(i,e){
            $(e).prop('title', '').removeClass('is-invalid').closest('div').find('label').removeClass('text-danger');
            $(e).popover('dispose');
        });
        //clean error box
        $(form).find('#error_message_box .error_messages').html('');
        $(form).find('#error_message_box').addClass('hide');

        $.ajax({
            url: $(form).prop('action'),
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.status) {
                    bootbox.alert(response.message);
                    var imgsrc = response.url;
                    $('.chatbubble .top .avatar img').prop('src', imgsrc);
                    $('#thread_' + thread_id).find('img').prop('src', imgsrc);
                } else {
                    $(form).find('#error_message_box .error_messages').append('<p><b>' + response.message + '</b></p>');

                    $.each(response.fields, function(i,e){
                        $('#'+i+',.'+i).prop('title', e).addClass('is-invalid').closest('div').find('label').addClass('text-danger');
                        Utils.popover($('#'+i+',.'+i), {
                            t: 'hover',
                            p: 'top',
                            m: e
                        });
                        $(form).find('#error_message_box .error_messages').append('<p>' + e + '</p>');
                    });

                    $(form).find('#error_message_box').removeClass('hide');
                }
            },
            complete: function() {
                $(form).LoadingOverlay("hide");
                $(form).data('running', false);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    this.addGroupMember = function(elem)
    {
        var $this = $(elem);
        var mid   = $('#manageGroupModal #findUserForGroup').val();
        var thread_id = $('#manageGroupModal #modal_thread_id').val();
        var data = self.get_thread_data(thread_id);
        if (mid.trim() != '') {
            if (!$this.hasClass('clicked')) {
                $this.addClass('clicked');
                $('#manageGroupModal .modal-content').LoadingOverlay("show", {zIndex: 9999999});
                $.ajax({
                    url  : window.base_url('message/addparticipant'),
                    type : 'get',
                    data: {
                        'thread_id' : thread_id,
                        'public_id' : mid
                    },
                    success : function(response) {
                        // console.log(response);
                        if (response.status) {
                            var e = response.data;
                            var kicklink = '';
                            if (data.starter == self.currentUser) {
                                kicklink = `<i class="js-remove kick_participant pull-right" data-user="${e.user_id}" style="cursor:pointer">✖</i>`;
                            }
                            var tpl = `<li class="ttmulti-selection list-group-item padding-5">
                                        <img width="30" height="30" style="vertical-align: middle;" src="${window.public_url() + "assets/profile/"+e.Photo}">
                                        <span>${e.user_name}</span>
                                        ${kicklink}
                                    </li>`;

                            $('#manageGroupModal .participant-list').append(tpl);
                            $('#manageGroupModal #findUserForGroup').val('');
                        } else {
                            bootbox.alert(response.message);
                        }
                    },
                    complete: function(r) {
                        $('#manageGroupModal .modal-content').LoadingOverlay("hide");
                        $this.removeClass('clicked');
                    }
                });
            }
        }
    }

    this.leaveGroup = function(elem)
    {
        var $this = $(elem);
        var thread_id = $('#manageGroupModal #modal_thread_id').val();
        bootbox.confirm('Are you sure you want to leave this group?', function(result){
            if (result) {
                $.ajax({
                    url  : window.base_url('message/leavegroup'),
                    type : 'get',
                    data: {
                        'thread_id' : thread_id
                    },
                    success : function(response) {
                        if (response.status) {
                            $('#manageGroupModal').modal('hide');
                            self.totalMsg = 0;
                            self.getThreads();
                            self.clearThread();
                        }
                    }
                });
            }
        });
    }

    this.kickParticipant = function(elem)
    {
        var $this = $(elem);
        var thread_id = $('#manageGroupModal #modal_thread_id').val();
        bootbox.confirm('Are you sure you want to kick ' + $this.closest('li').find('span').text(), function(result){
            if (result) {
                $.ajax({
                    url  : window.base_url('message/leavegroup'),
                    type : 'get',
                    data: {
                        'thread_id' : thread_id,
                        'id'        : $this.data('user')
                    },
                    success : function(response) {
                        if (response.status) {
                            $this.closest('li').remove();
                            self.totalMsg = 0;
                            self.getThreads();
                        }
                    }
                });
            }
        });
    }

}


var Chatbox = new Chatbox();
$(document).ready(function(){
    Chatbox._init();
});