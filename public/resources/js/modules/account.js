function Account() {
    // because this is overwritten on jquery events
    var self = this;

    this.info,
    this.address,
    this.iti

    /**
     * Initialize events
     */
    this._init = function()
    {

        self.set_events();
		self.set_configs();

    },

    /**
    * events delaration
    */
    this.set_events = function()
    {

        /**
        * login submit
        */
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            self.login(this);
        });

        /**
        * registration submit
        */
        $('#registrationForm').submit(function(e) {
            e.preventDefault();
            self.register(this);
        });

        $('#deliveryAgentApplicationForm, #setDeliveredOrderForm').submit(function(e) {
            e.preventDefault();
            Utils.save_form(this, function(){
                location.reload();
            });
        });

        $('#updateProfileForm').submit(function(e) {
            e.preventDefault();

            var countryData = self.iti.getSelectedCountryData();
            $(this).find('#countryData').val(JSON.stringify(countryData));

            Utils.save_form(this, function(){
                location.reload();
            });
        });

        $('#forgotPasswordForm').submit(function(e) {
            e.preventDefault();
            Utils.save_form(this, function(response){
                bootbox.alert(response.message, function(){
                    window.location = window.base_url('account/signin'); 
                });
            }, function(response) {
                // reset captcha
                Utils.show_form_errors($('#forgotPasswordForm'), response.fields, response.message);
                grecaptcha.reset();
            });
        });

        $('#resetPasswordForm').submit(function(e) {
            e.preventDefault();
            Utils.save_form(this, function(response){
                var cont = $('#resetPasswordForm').parent();
                $('#resetPasswordForm').remove();
                cont.html(`<div class="row justify-content-center">
                    <div class="col-12 col-md-8">
                        <h4>Reset Password</h4>
                        <div class="alert alert-success" role="alert">
                          Password has been changed successfully.
                        </div>
                        <button type="button" onclick="window.location='${window.base_url('account/signin')}'" name="" class="btn btn-success">Go to Login</button>
                    </div>
                </div>`);
            });
        });

        $('.deliveryAgentStatusToggle').change(function(e){
            self.updateAgentStatus(this);
        });

    }

    /**
    * usage of different libraries and plugins
    */
    this.set_configs = function()
    {

    },


    /**
    * login request
    */
    this.login = function(e)
    {
        
        // prenvet multiple calls
        if ($(e).data('running')) {
            return false;
        }
        $(e).data('running', true);
        $(e).LoadingOverlay("show", {
            background              : "rgba(255, 255, 255, 0.1)"
        })

        Utils.append_csrf_token(e);
        var formData = new FormData(e);

        $.ajax({
            url: $(e).prop('action'),
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.status) {
                    $('#error_message_box').text(response.message).addClass('hide');
                    window.location = response.redirect; 
                } else {
                    $('#password').val('');
                    $('#error_message_box').text(response.message).removeClass('hide');
                }
            },
            complete: function() {
                $(e).LoadingOverlay("hide");
                $(e).data('running', false);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        // $.post(e.prop('action'), e.serialize()).done(function(response) {
        //     if (response.status) {
        //         // $('html').css('background', 'white').find('.modal-overs').remove();
        //         $('#error_message_box').text(response.message).addClass('hide');
        //         window.location = window.base_url(); 
        //     } else {
        //         $('#password').val('');
        //         $('#error_message_box').text(response.message).removeClass('hide');

        //         // no need to remove loading on success, let it redirect
        //         $('.box-content').LoadingOverlay("hide");
        //         $(e).data('running', false);
        //     }
        // });

    },

    /**
    * register request
    */
    this.register = function(e)
    {
        // prenvet multiple calls
        if ($(e).data('running')) {
            return false;
        }
        $(e).data('running', true);

        $('.modal-content').LoadingOverlay("show", {
            background              : "rgba(255, 255, 255, 0.1)"
        })

        var countryData = self.iti.getSelectedCountryData();
        $(e).find('#countryData').val(JSON.stringify(countryData));

        Utils.append_csrf_token(e);
        var formData = new FormData(e);
        
        // reset input erros
        Utils.reset_form_errors(e);
        
        $.ajax({
            url: $(e).prop('action'),
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.status) {
                    $('#error_message_box').addClass('hide');
                    bootbox.alert(response.message, function(){
                        window.location = window.base_url('account/signin'); 
                    });
                } else {
                    // bootbox.alert(response.message);
                    Utils.show_form_errors(e, response.fields, response.message);
                }
            },
            complete: function() {
                $('.modal-content').LoadingOverlay("hide");
                $(e).data('running', false);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }


    this.toggle_account_no = function(elem)
    {
        if ($(elem).hasClass('show')) {
            $(elem).removeClass('show').addClass('notshow').html('<strong>SHOW</strong>');
            $(elem).parent('div').find('.account_no_holder').find('strong').toggleClass('hide');
        } else {
            $(elem).parent('div').find('.account_no_holder').find('strong').toggleClass('hide');
            $(elem).removeClass('notshow').addClass('show').html('<strong>HIDE</strong>');
        }
    }


    this.editProfile = function()
    {
        var form  = '#updateProfileForm';
        var modal = '#updateProfileModal';
        Utils.show_form_modal(modal, form, false, function(){
            if (self.info) {
                self.initializeMobileInput('#account_mobile', self.info.account_country);
                $('.iti.iti--allow-dropdown').css('width', '100%');
                $(form).find('.image-preview').prop('src', self.info.photo);
                Utils.set_form_input_value(form, self.info);
            }
        });
    }

    this.applyAsAgent = function()
    {
        var form  = '#deliveryAgentApplicationForm';
        var modal = '#deliveryAgentApplicationModal';
        Utils.show_form_modal(modal, form, false, function(){
            Utils.set_form_input_value(form, self.info);
            $(form).find('.custom-file-label').text('Choose file');
        });
    }

    this.updateAgentStatus = function(elem)
    {
        var checkbox    = $(elem);
        var data        = checkbox.data();
        var status      = checkbox.is(":checked");
        $.ajax({
            url: window.base_url('account/update_agent_status/' + data.code),
            type: 'get',
            data: {'status' : status},
            success: function (response) {
                if (!response.status) {
                    // failed
                    bootbox.alert(response.message, function(){
                        location.reload();
                    })
                }
            }
        });
    }

    this.markDelivered = function(code)
    {
        var form  = '#setDeliveredOrderForm';
        var modal = '#setDeliveredOrderModal';
        Utils.show_form_modal(modal, form, false, function(){
            $(form).find('#order_id').val(code);
            $(form).find('.custom-file-label').text('Choose file');
        });
    }

    this.viewOrderStatus = function(code)
    {
        $.LoadingOverlay("show");

        $.get(window.base_url('account/get_order_status/' + code)).done(function(response) {

            if (response.status) {

                var $modalObj = $('#orderStatusModal');

                if (Object.keys(response.data).length) {
                    var tpl = '';

                    $.each(response.data, function(i,e) {

                        var by = '';
                        if (e.UpdatedBy && e.UpdatedBy != '') {
                            by = `<div class="small float-right text-green">By: ${e.UpdatedBy}</div>`;
                        }

                        tpl += `<div class="text-bold text-info">
                                    ${e.Status} <span class="small text-black ml-2">${e.Datetime}</span>
                                    ${by}
                                </div>`;

                        if (e.Remarks && e.Remarks != '') {
                            tpl += `<div class="small float-left"><b>Remarks:</b> <span>${e.Remarks}</span></div>`;
                        }

                        if (e.Image && e.Image != '') {
                            // tpl += `<div class="float-right"><img src="${e.Image}" class="img-fluid" style="max-width: 300px;"></div>`;
                            tpl += `<div class="float-right">
                                        <a href="${e.Image}" data-toggle="lightbox" data-gallery="example-gallery">
                                            <img src="${e.Image}" class="img-fluid" style="max-width:150px;">
                                        </a>
                                  </div>`;
                        }

                        tpl += '<div class="clearfix"></div><hr/>';
                    });

                    $modalObj.find('.order_status_cont').html(tpl)
                } else {
                    $modalObj.find('.order_status_cont').html('<td>No record found.</td>');
                }
                
                $modalObj.modal({
                    backdrop : 'static',
                    keyboard : false
                });

            }
            $.LoadingOverlay("hide");
        });
    }

    this.initializeMobileInput = function(id, def = 'ph')
    {
        if (self.iti) {
            self.iti.destroy();
        }
        var input = document.querySelector(id);
        self.iti = window.intlTelInput(input, {
            initialCountry: def,
            preferredCountries: ["ph", 'bn'],
            separateDialCode: true
        });

        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        var reset = function() {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        // on blur: validate
        input.addEventListener('blur', function() {
            reset();
            if (input.value.trim()) {
                if (self.iti.isValidNumber()) {
                    validMsg.classList.remove("hide");
                } else {
                    input.classList.add("error");
                    var errorCode = self.iti.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                }
            }
        });

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    }

}

var Account = new Account();
$(document).ready(function(){
    Account._init();
});