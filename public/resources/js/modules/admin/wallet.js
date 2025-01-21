function Wallet() {

    // because this is overwritten on jquery events
    var self = this;

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

    }

    /**
    * usage of different libraries and plugins
    */
    this.set_configs = function()
    {

    },


    this.confirmDeposit = function(code)
    {
        var tr = $('#deposit_' + code);
        console.log(tr)
        if (tr.length) {
            var name   = tr.find('td:nth(1)').text();
            var amount = tr.find('td:nth(4)').text();
            bootbox.confirm({
                message  : `Are you sure you want to <label class="label label-success">confirm</label> ${amount} deposit of ${name}?`,
                buttons: {
                    confirm: {
                        label: 'Confirm',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-default'
                    }
                },
                callback : function(r){
                    if (r) {
                        $.LoadingOverlay("show", {zIndex: 999});
                        $.ajax({
                            url: window.base_url('deposits/confirm_deposit/' + code),
                            type: 'GET',
                            success: function (response) {
                                if (response.status) {
                                    bootbox.alert(response.message, function(){
                                        location.reload(); //easy way, just reload the page
                                    });
                                } else {
                                    $.LoadingOverlay("hide");
                                }
                            }
                        });
                    }
                }
            });
        }
    }

    this.declineDeposit = function(code)
    {
        var tr = $('#deposit_' + code);
        if (tr.length) {
            var name   = tr.find('td:nth(1)').text();
            var amount = tr.find('td:nth(4)').text();
            bootbox.confirm({
                message  : `Are you sure you want to <label class="label label-danger">decline</label> ${name} deposit amounting to ${amount}?`,
                buttons: {
                    confirm: {
                        label: 'Decline',
                        className: 'btn-danger'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-default'
                    }
                },
                callback : function(r){
                    if (r) {
                        $.LoadingOverlay("show", {zIndex: 999});
                        $.ajax({
                            url: window.base_url('deposits/decline_deposit/' + code),
                            type: 'GET',
                            success: function (response) {
                                if (response.status) {
                                    bootbox.alert(response.message, function(){
                                        location.reload(); //easy way, just reload the page
                                    });
                                } else {
                                    $.LoadingOverlay("hide");
                                }
                            }
                        });
                    }
                }
            });
        }
    }

}


var Wallet = new Wallet();
$(document).ready(function(){
    Wallet._init();
});