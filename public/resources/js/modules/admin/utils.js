function Utils() {
    // because this is overwritten on jquery events
    var self = this;

    /**
     * Initialize events
     */
    this._init = function()
    {

        self.set_events();
        self.set_configs();

        // Stick footer at the bottom
        Utils.stickFooter();

        // keep scroll position on script reload
        if (sessionStorage.scrollTop != "undefined") {
            $(window).scrollTop(sessionStorage.scrollTop);
        }

    },

    /**
    * events delaration
    */
    this.set_events = function()
    {

        /**
        * image upload preview
        */
        $(document).on('change', 'input.image-upload-input', function(){
            self.previewImageFile(this);
        });
        $('img.image-preview').prop('title', 'Click to upload');
        $(document).on('click', 'img.image-preview', function(){
            $(this).closest('.image-upload-container').find('input.image-upload-input').trigger('click');
        });

        // resize events
        $(window).resize(function(){
            
            // sticky footer on bottom
            Utils.stickFooter();

        });

        // keep scroll position on script reload
        $(window).scroll(function() {
            sessionStorage.scrollTop = $(this).scrollTop();
        });


        $("input, textarea").attr('autocomplete', 'off');

    }

    /**
    * usage of different libraries and plugins
    */
    this.set_configs = function()
    {

        bootbox.setDefaults({
            size: 'default'
        });

        $.LoadingOverlaySetup({
            zIndex : 99999
        });

        $( document ).ajaxComplete(function(event, xhr, settings) {
            if (xhr.status == 403) {
                // invalid token, refresh page
                // bootbox.alert('Invalid request token!', function(){
                    location.reload();
                // });
            } else if (typeof xhr.responseJSON !== 'undefined' && typeof settings.type != 'undefined' && settings.type == 'POST') {
                // console.log(event, xhr, settings, 'update token');
                self.update_csrf_token(xhr.responseJSON);
            }
        });
    },


    this.append_csrf_token = function(form) 
    {
        if ($(form).find('input.csrf-token').length <= 0) {
            $(form).append(`<input class="csrf-token" type="hidden" name="${$global.csrfName}" value="${$global.csrfVal}">`);
        } else {
            $(form).find('input.csrf-token').val($global.csrfVal);
        }
    }

    this.update_csrf_token = function(data) 
    {
        if (typeof data.token !== 'undefined') {
            $global.csrfVal = data.token;
        }
    }

    // FORM HELPERS

    this.reset_form_errors = function(form)
    {
        $(form).find('#error_message_box .error_messages').html('');
        $(form).find('#error_message_box').addClass('hide');

        $.each($(form).find('input,select,textarea'), function(i,e){
            $(e).prop('title', '').closest('div').removeClass('has-error').find('label').removeClass('text-danger');
            $(e).popover('destroy');
        });
    }

    this.show_form_errors = function(form, fields, message = false)
    {
        console.log(fields, message);
        var errors = '';
        if (message && typeof(fields) == 'undefined') {
            errors += '<p class="small">' + message + '</p>';
        }
        $.each(fields, function(i,e){
            $('#'+i+',.'+i).prop('title', e).addClass('is-invalid').closest('div').find('label').addClass('text-danger');
            Utils.popover($('#'+i+',.'+i), {
                t: 'hover',
                p: 'top',
                m: e
            });
            errors += '<p class="small">' + e + '</p>';
        });

        $(form).find('#error_message_box .error_messages').html(errors);
        $(form).find('#error_message_box').removeClass('hide');
    }

    this.save_form = function(form, callback = false, error_callback = false, complete_callback = false)
    {
        // prenvet multiple calls
        if ($(form).data('running')) {
            return false;
        }
        $(form).data('running', true);

        $(form).LoadingOverlay("show", {
            background              : "rgba(255, 255, 255, 0.4)"
        });


        self.append_csrf_token(form);
        var formData = new FormData(form);
        
        // reset input erros
        self.reset_form_errors(form);

        $.ajax({
            url: $(form).prop('action'),
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.status) {
                    $('#error_message_box').addClass('hide');
                    if (callback) {
                        callback();
                    } else {
                        // default, show message then reload
                        bootbox.alert(response.message, function(){
                            location.reload();
                        });
                    }
                } else {
                    if (error_callback) {
                        error_callback();
                    } else {
                        // bootbox.alert(response.message);
                        self.show_form_errors(form, response.fields, response.message);
                    }
                }
            },
            complete: function() {
                $(form).LoadingOverlay("hide");
                $(form).data('running', false);
                if (complete_callback) {
                    complete_callback();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    this.show_form_modal = function(modalSector, formSelector, modal_title = false, todo_fnc = false)
    {   
        // reset form data
        $(formSelector).trigger("reset");

        // reset hidden
        $(formSelector).find('#Code').val('');

        self.reset_form_errors(formSelector);

        if (todo_fnc) {
            todo_fnc();
        }
        if (modal_title) {
            $(modalSector).find('.modal-title').html(modal_title);    
        }
        
        $(modalSector).modal({
            backdrop : 'static',
            keyboard : false
        });
    }

    this.set_form_input_value = function(form, fields)
    {
        $.each(fields, function(id, value) {
            $(form).find('#' + id).val(value);
        })
    }

    // END FORM HELPER

    this.isBreakpoint = function( alias ) 
    {
        return $('.device-' + alias).is(':visible');
    }


    /**
    * generate random string
    */
    this.generateString = function(length = 6, withNumber = false)
    {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

        if (withNumber) {
            possible += '0123456789';
        }

        for (var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }

        return text;
    }

    /**
    * get random item from array
    */
    this.getRandomItem = function(items)
    {
        return items[Math.floor(Math.random()*items.length)];
    }


    /**
    * shuffle array
    */
    this.shuffle = function(array) {
        var currentIndex = array.length, temporaryValue, randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {

            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;

        }

        return array;
    }


    /**
    * preview image upload
    */
    this.previewImageFile = function(input)
    {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
            if ($.inArray(file.type, ValidImageTypes) >= 0) {
                if(file.size>2097152) {
                    bootbox.alert('File size is larger than 2MB!');
                    this.resetPreviewImageFile(input);
                } else {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(input).closest('.image-upload-container').find('img.image-preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            } else {
                bootbox.alert('Invalid file type.');
                this.resetPreviewImageFile(input);
            }
        } else {
            this.resetPreviewImageFile(input);
        }
    },

    this.resetPreviewImageFile = function(input)
    {
        $(input).val('');
        var default_img = $(input).data('default');
        $(input).closest('.image-upload-container').find('img.image-preview').attr('src', (default_img ? default_img : window.public_url('assets/profile/') + 'avatar_default.jpg'));
    }


    /*
    * show popover message
    */
    this.popover = function($obj, params)
    {
        $obj.popover({
              trigger: params.t,
              placement: params.p,
              content: params.m,
              template: "<div class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"text-danger popover-content\"><p></p></div></div></div>"
            });
        if (params.t == 'manual') {
            $obj.popover("show");
        }

        $obj.one('focus', function (){
            $(this).prop('title', '').removeClass('is-invalid').closest('div').find('label').removeClass('text-danger');
            $(this).popover('destroy');
        });
    }

    /**
    * keep footer on bottom on small window
    */
    this.stickFooter = function()
    {
        if ($('#footer').lenght > 0) {
            var bodyH = $(window).height();
            var headH = $('#header').outerHeight();
            var mainH = $('#main-content').height();
            var menuH = $('#mobile-menu').outerHeight();
            var footH = $('#footer').outerHeight();

            $('#main-content').css('min-height', (bodyH-(headH+menuH+footH)) + 'px');
        }
    }

    this.highlightMatch = function($obj, term)
    {
        // remove any old highlighted terms
        $obj.removeHighlight();
        // disable highlighting if empty
        if (term != '') {
            $obj.highlight( term );
        }
    }

    this.numberWithCommas = function (x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
}

var Utils = new Utils();
$(document).ready(function(){
    Utils._init();
});