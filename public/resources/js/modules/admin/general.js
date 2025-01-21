function General() {

    // because this is overwritten on jquery events
    var self = this;

    this.itemData = {};

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
            console.log($(this).prop('id'));
            Utils.save_form(this, function(res) {
                console.log(res);
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

    this.getData = function(id)
    {   
        var match = false;
        $.each(self.itemData, function(i,e){
            if (e.id == id) {
                match = e;
                return false;
            }
        });

        return match;
    }

    this.updateBillerLogo = function(biller_code)
    {   

        var form  = '#billerLogoForm';
        var modal = '#billerLogoModal';
        Utils.show_form_modal(modal, form, 'Update Biller Logo', function(){
            $(form).find('.image-preview').prop('src', $('#biller_' + biller_code).find('.logo-small').prop('src'));
            $(form).find('#Code').val(biller_code);
            $(form).find('#biller_name').val($('#biller_' + biller_code).find('td:nth(1)').text());
            $(form).find('#biller_type').val($('#biller_' + biller_code).find('td:nth(2)').data('val'));
        });

    }


    this.updateEcashService = function(code)
    {
        var form  = '#ecashServiceForm';
        var modal = '#ecashServiceModal';
        Utils.show_form_modal(modal, form, 'Update Ecash Service', function(){
            $(form).find('.image-preview').prop('src', $('#item_' + code).find('.logo-small').prop('src'));
            $(form).find('#Code').val(code);
            $(form).find('#service_name').val($('#item_' + code).find('td:nth(1)').text());
            $(form).find('#service_description').val($('#item_' + code).find('td:nth(3)').text());
        });
    }


    this.viewOrderInvoice = function(code)
    {

        $.LoadingOverlay("show", {zIndex: 999});
        $.ajax({
            url: window.base_url('orders/invoice/' + code),
            type: 'GET',
            success: function (response) {
                if (response.length > 0) {
                    $('#invoiceModal').find('.modal-body').html(response);
                    $('#invoiceModal').modal('show');
                }
            },
            complete: function() {
                $.LoadingOverlay("hide");
            }
        });

    }

    this.updateOrderStatus = function(code, status)
    {

        var $status_selector = $('#orderStatusForm #order_status');

        $status_selector.val(status);
        $status_selector.find('option').removeClass('hide');

        $.each($status_selector.find('option'), function(i,e) {
            var val = $(e).prop('value');
            if (val < status) {
                $(e).addClass('hide');
            }
        });

        $('#orderStatusForm #Code').val(code);

        $('#orderStatusModal').modal({
            backdrop : 'static',
            keyboard : false
        });
    }

    this.viewOrderStatus = function(code)
    {
        $.LoadingOverlay("show");

        $.get(window.base_url('orders/get_order_status/' + code)).done(function(response) {

            if (response.status) {

                var $modalObj = $('#viewOrderStatusModal');

                if (Object.keys(response.data).length) {
                    var tpl = '';

                    $.each(response.data, function(i,e) {

                        var by = '';
                        if (e.UpdatedBy && e.UpdatedBy != '') {
                            by = `<div class="small pull-right">By: ${e.UpdatedBy}</div>`;
                        }

                        tpl += `<div class="text-info">
                                    <span class="text-bold">${e.Status}</span> <span class="small text-black ml-2">&nbsp;&nbsp;${e.Datetime}</span>
                                    ${by}
                                </div>`;

                        if (e.Remarks && e.Remarks != '') {
                            tpl += `<div class="small "><b>Remarks:</b> <span>${e.Remarks}</span></div>`;
                        }

                        if (e.Image && e.Image != '') {
                            // tpl += `<div class="float-right"><img src="${e.Image}" class="img-fluid" style="max-width: 300px;"></div>`;
                            tpl += `<div class="">
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


    this.viewECData = function(id, field, title)
    {
        var data = this.getData(id);

        $('#successMessageModal .title').text(title);
        var table = $('#successMessageModal .transaction-table');
        table.html('');
        var items = $.parseJSON(data[field]);
        if (items) {
            $.each(items, function(i,e) {
                table.append(`<tr><td>${i}</td><td>${e}</td></tr>`);
            });
        } else {
            table.html(`<tr><td>Not available.</td></tr>`);
        }
        $('#successMessageModal').modal({
            backdrop : 'static',
            keyboard : false
        });
    }

    this.viewECRewards = function(id)
    {
        var data = this.getData(id);

        $('#successMessageModal .title').text('Distributed Rewards');
        var table = $('#successMessageModal .transaction-table');
        table.html('');
        if (data.Commission > 0) {
            $.each(data.Rewards, function(i,e) {
                table.append(`<tr><td>${e.Type}</td><td>${e.Firstname + ' ' + e.Lastname}</td><td>${e.Amount}</td></tr>`);
            });
        } else {
            table.html(`<tr><td>No reward to distribute.</td></tr>`);
        }
        $('#successMessageModal').modal({
            backdrop : 'static',
            keyboard : false
        });
    }

    this.editOutlet = function(id)
    {   
        var data = this.getData(id);

        console.log(data);
        if (data) {
            var form  = '#partnerOutletForm';
            var modal = '#partnerOutletModal';
            Utils.show_form_modal(modal, form, false, function(){
                Utils.set_form_input_value(form, data);
                self.loadCityOptions('#City', '#Province', '#Barangay', data.City, function(){
                    self.loadBarangayOptions('#Barangay', '#City', data.Barangay);
                });
            });
        }
    }






    this.loadCityOptions = function(target, e, baragay_target, selected = false, callback = false)
    {
        $(target).html(window.emptySelectOption).prop('disabled', true);
        $(baragay_target).html(window.emptySelectOption).prop('disabled', true);

        $.LoadingOverlay("show");

        $.get(window.public_url('get/city'), {'provCode' : $(e).val()}).done(function(response) {
            if (response.status) {
                var options = window.emptySelectOption;
                $.each(response.data, function(i, e){
                    options += '<option value="' + e.citymunCode + '" ' + (selected && selected == e.citymunCode ? 'selected' : '') + '>' + e.citymunDesc + '</option> \n';
                });
                $(target).html(options).prop('disabled', false);
            } else {
                $(target).html(window.emptySelectOption);
            }

            if (callback) {
                callback();
            }

            $.LoadingOverlay("hide");
        });
    }

    this.loadBarangayOptions = function(target, e, selected = false, callback = false)
    {
        $(target).html(window.emptySelectOption).prop('disabled', true);

        $.LoadingOverlay("show");

        $.get(window.public_url('get/barangay'), {'citymunCode' : $(e).val()}).done(function(response) {
            if (response.status) {
                var options = window.emptySelectOption;
                $.each(response.data, function(i, e){
                    options += '<option value="' + e.brgyCode + '" ' + (selected && selected == e.brgyCode ? 'selected' : '') + '>' + e.brgyDesc + '</option> \n';
                });
                $(target).html(options).prop('disabled', false);
            } else {
                $(target).html(window.emptySelectOption);
            }

            if (callback) {
                callback();
            }

            $.LoadingOverlay("hide");
        });
    }

}


var General = new General();
$(document).ready(function(){
    General._init();
});