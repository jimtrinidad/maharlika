function Accounts() {

    // because this is overwritten on jquery events
    var self = this;

    // initialize module variables
    this.accountData = {}

    /**
     * Initialize events
     */
    this._init = function() 
    {

        self.set_events();
        self.set_configs();

    }

    /**
    * events delaration
    */
    this.set_events = function()
    {

        $('.modalForm').submit(function(e) {
            e.preventDefault();
            Utils.save_form(this);
        });

        $('.accountStatusToggle').change(function(e){
            self.updateAccountStatus(this);
        });

    }

    /**
    * usage of different libraries and plugins
    */
    this.set_configs = function()
    {
        
    }

    this.getAccount = function(id)
    {   

        var match = false;
        $.each(self.accountData, function(i,e){
            if (e.id == id) {
                match = e;
                return false;
            }
        });

        return match;
    }

    this.updateAccountStatus = function(elem)
    {
        var checkbox    = $(elem);
        var data        = checkbox.data();
        var status      = checkbox.is(":checked");
        $.ajax({
            url: window.base_url('accounts/update_status/' + data.code),
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


    this.editAccount = function(id)
    {
        var data = self.getAccount(id);
        console.log(data);
        if (data != false) {
            var form  = '#updateAccountForm';
            var modal = '#updateAccountModal';
            Utils.show_form_modal(modal, form, 'Update Account', function(){
                Utils.set_form_input_value(form, data);
                $(form).find('.image-preview').prop('src', window.public_url() + 'assets/profile/default.jpg');
                if (data.Photo) {
                    $(form).find('.image-preview').prop('src', window.public_url() + 'assets/profile/' + data.Photo);
                }
            });
        }

    }

}


var Accounts = new Accounts();
$(document).ready(function(){
    Accounts._init();
});