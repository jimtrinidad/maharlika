function General() {

    // because this is overwritten on jquery events
    var self = this;

    this.address,
    this.delivery_coverage,

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

        $('#userAddressForm').submit(function(e) {
            e.preventDefault();
            Utils.save_form(this, function() {
                location.reload();
            });
        });


        $(document).on('click', '#addDeliveryCoverage', function(e){
            e.preventDefault();
            self.addDeliveryCoverage();
        });

        $('#agentDeliveryAddressForm').submit(function(e) {
            e.preventDefault();
            Utils.save_form(this, function(rsp) {
                if (rsp.status) {
                    self.getDeliveryCoverage();
                    $('#agentDeliveryAddressModal').modal('hide');
                }
            });
        });

    }

    /**
    * usage of different libraries and plugins
    */
    this.set_configs = function()
    {
        
    }

    this.addUserAddress = function()
    {   

        var form  = '#userAddressForm';
        var modal = '#userAddressModal';
        Utils.show_form_modal(modal, form, 'Add Address', function(){
            
        });

    }

    this.editUserAddress = function()
    {
        var form  = '#userAddressForm';
        var modal = '#userAddressModal';
        Utils.show_form_modal(modal, form, 'Edit Address', function() {
            $(form).find('#AddressCity').prop('disabled', false);
            $(form).find('#AddressBarangay').prop('disabled', false);
            Utils.set_form_input_value(form, {
                AddressID       : self.address.id,
                AddressProvince : self.address.Province,
                AddressCity     : self.address.City,
                AddressBarangay : self.address.Barangay,
                AddressStreet   : self.address.Street,
            });

            self.loadCityOptions('#AddressCity', '#AddressProvince', '#AddressBarangay', self.address.City, function(){
                self.loadBarangayOptions('#AddressBarangay', '#AddressCity', self.address.Barangay);
            });
        });
    }


    this.getDeliveryCoverage = function()
    {   

        $.LoadingOverlay("show");

        $.get(window.public_url('account/delivery_coverage')).done(function(response) {
            if (response.status) {

                var $modalObj = $('#addessListModal');
                $modalObj.find('.modal-title').text('Delivery Coverage Area');
                $modalObj.find('.add-address').attr('id', 'addDeliveryCoverage');

                self.delivery_coverage = response.data;

                if (Object.keys(response.data).length) {
                    var tpl = '<tr><th>Province</th><th>City/Muni</th><th>Barangay</th><th></th></tr>';

                    $.each(response.data, function(i,e) {
                        tpl += `<tr>
                                    <td>${e.names.Province}</td>
                                    <td>${e.names.MuniCity}</td>
                                    <td>${e.names.Barangay}</td>
                                    <td style="width:90px;" class="text-center">
                                        <a class="btn btn-sm btn-primary" href="javascript:;" title="Edit" onclick="General.editDeliveryCoverage(${e.id})"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-sm btn-danger" href="javascript:;" title="Delete" onclick="General.deleteDeliveryCoverage(${e.id})"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>`;
                    });

                    $modalObj.find('.address-table-list').html(tpl)
                } else {
                    $modalObj.find('.address-table-list').html('<td>No record found.</td>');
                }
                
                $modalObj.modal({
                    backdrop : 'static',
                    keyboard : false
                });

            }
            $.LoadingOverlay("hide");
        });

    }


    this.addDeliveryCoverage = function()
    {   

        var form  = '#agentDeliveryAddressForm';
        var modal = '#agentDeliveryAddressModal';
        Utils.show_form_modal(modal, form, 'Add Delivery Coverage Area', function(){
            Utils.set_form_input_value(form, {
                DAAddressID       : '',
                DAAddressProvince : '',
                DAAddressCity     : '',
                DAAddressBarangay : '',
            });
        });

    }

    this.editDeliveryCoverage = function(id)
    {
        var form  = '#agentDeliveryAddressForm';
        var modal = '#agentDeliveryAddressModal';

        if (self.delivery_coverage[id] != 'undefined') {
            var address = self.delivery_coverage[id];
            Utils.show_form_modal(modal, form, 'Edit Delivery Converage Area', function() {
                $(form).find('#DAAddressCity').prop('disabled', false);
                $(form).find('#DAAddressBarangay').prop('disabled', false);
                Utils.set_form_input_value(form, {
                    DAAddressID       : address.id,
                    DAAddressProvince : address.Province,
                    DAAddressCity     : address.City,
                    DAAddressBarangay : address.Barangay,
                });

                self.loadCityOptions('#DAAddressCity', '#DAAddressProvince', '#DAAddressBarangay', address.City, function(){
                    self.loadBarangayOptions('#DAAddressBarangay', '#DAAddressCity', address.Barangay);
                });
            });
        }
    }

    this.deleteDeliveryCoverage = function(id)
    {
        if (self.delivery_coverage[id] != 'undefined') {
            var address = self.delivery_coverage[id];
            bootbox.confirm('Are you sure you want to <label class="label label-danger">remove</label> ' + Object.values(address.names).reverse().join(' ') + ' on covered area?', function(r){
                if (r) {
                    $.LoadingOverlay("show", {zIndex: 999});
                    $.ajax({
                        url: window.base_url('account/delete_delivery_coverage/' + address.id),
                        type: 'GET',
                        success: function (response) {
                            if (response.status) {
                                self.getDeliveryCoverage();
                            } else {
                                bootbox.alert(response.message);
                            }
                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                }
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