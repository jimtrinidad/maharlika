function Delivery() {

    // because this is overwritten on jquery events
    var self = this;

    this.agents = {};

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

        $('#updateAgentStatusForm').submit(function(e) {
            e.preventDefault();
            Utils.save_form(this, function() {
                location.reload();
            });
        });

    }

    /**
    * usage of different libraries and plugins
    */
    this.set_configs = function()
    {
        
    }

    this.getAgent = function(code)
    {   

        if (typeof(this.agents[code]) != 'undefined') {
            return this.agents[code];
        }

        return false;
    }

    this.updateAgentStatus = function(code)
    {   

        var form  = '#updateAgentStatusForm';
        var modal = '#updateAgentStatusModal';
        var agentdata = self.getAgent(code);
        if (agentdata) {
            Utils.show_form_modal(modal, form, 'Update Delivery Agent Status', function(){
                $(form).find('#Code').val(code);
                $(form).find('#agent_status').val(agentdata.Status);
                $(form).find('#agent_man_type').val(agentdata.ManType);
            });
        }

    }

    this.cancelAgentApplication = function(code)
    {
        var tr = $('#agent_' + code);
        if (tr.length) {
            var name   = tr.find('td:nth(0)').text();
            bootbox.confirm({
                message  : `Are you sure you want to <label class="label label-danger">decline</label> ${name} application as delivery agent?`,
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
                            url: window.base_url('delivery/decline_agent_application/' + code),
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


var Delivery = new Delivery();
$(document).ready(function(){
    Delivery._init();
});