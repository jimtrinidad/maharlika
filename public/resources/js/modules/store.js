function Store() {
    // because this is overwritten on jquery events
    var self = this;
    
    this.itemData = {};
    this.profile = false;
    this.categories = [];
    this.sub_categories = [];
    this.store_locations;

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


        $('#storeProfileForm, #itemForm').submit(function(e) {
            e.preventDefault();
            Utils.save_form(this);
        });

        $(document).on('click', '#addStoreLocation', function(e){
            e.preventDefault();
            self.addStoreLocation();
        });

        $('#storeAddressForm').submit(function(e) {
            e.preventDefault();
            Utils.save_form(this, function(rsp) {
                if (rsp.status) {
                    self.showStoreLocations();
                    $('#storeAddressModal').modal('hide');
                }
            });
        });

    }

    /**
    * usage of different libraries and plugins
    */
    this.set_configs = function()
    {

    },

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

    this.updateProfile = function()
    {
        var form  = '#storeProfileForm';
        var modal = '#storeProfileModal';
        Utils.show_form_modal(modal, form, false, function(){
            if (self.profile) {
                // console.log(self.profile);
                Utils.set_form_input_value(form, {
                    'Name'    : self.profile.Name,
                    'Address' : self.profile.Address,
                    'Contact' : self.profile.Contact,
                    'Email'   : self.profile.Email,
                    'MinimumOrder'   : self.profile.MinimumOrder,
                    'SDProvince': self.profile.Province
                });

                General.loadCityOptions('#SDCity', '#SDProvince', '#SDBarangay', self.profile.City, function(){
                    General.loadBarangayOptions('#SDBarangay', '#SDCity', self.profile.Barangay);
                });
            }
        });
    }


    // product setup - prepare sub category on category change
    this.get_sub_categories = function(category, selected = false) 
    {
        $('#itemForm').find('#SubCategory').html('<option value=""></option>');
        if (typeof(self.sub_categories[category]) !== 'undefined') {
            $.each(self.sub_categories[category], function(i, e) {
                var selected_text = '';
                if (selected && selected == e.id) {
                    selected_text = 'selected="selected"';
                }
                $('#itemForm').find('#SubCategory').append(`<option value="${e.id}" ${selected_text} >${e.Name}</option>`);
            });
        }
    }


    this.addProduct = function()
    {
        var form  = '#itemForm';
        var modal = '#itemModal';
        Utils.show_form_modal(modal, form, 'Add Store Product', function(){
            $(form).find('.image-preview').prop('src', window.public_url() + 'assets/products/default.png');

            self.get_sub_categories(0);

            $(form).find('#SearchKeywords').tagsinput('destroy');
            $(form).find('#SearchKeywords').tagsinput();
            $(form).find('#Description').summernote('destroy');
            $(form).find('#Description').summernote('reset');

            $(form).find('#Code').val('');
        });
    }

    this.editProduct = function(id)
    {
        var data  = self.getData(id);

        if (data) {

            var form  = '#itemForm';
            var modal = '#itemModal';
            Utils.show_form_modal(modal, form, 'Update Product', function(){
                Utils.set_form_input_value(form, data);
                $(form).find('#Price').val(parseFloat(data.Price));
                $(form).find('#CommissionValue').val(parseFloat(data.CommissionValue));
                $('#itemForm .image-preview').prop('src', window.public_url() + 'assets/products/default.png');
                if (data.Image) {
                    $('#itemForm .product_image').prop('src', window.public_url() + 'assets/products/' + data.Image);
                }
                if (data.PartnerImage) {
                    $('#itemForm .partner_image').prop('src', window.public_url() + 'assets/products/' + data.PartnerImage);
                }

                self.get_sub_categories(data.Category, data.SubCategory);

                $(form).find('#SearchKeywords').tagsinput('destroy');
                $(form).find('#SearchKeywords').tagsinput();
                $(form).find('#Description').summernote('destroy');
                $(form).find('#Description').summernote();

            });
        }
    }

    this.deleteProduct = function(id)
    {
        var data = self.getData(id);
        if (data) {
            bootbox.confirm('Are you sure you want to <label class="label label-danger">delete</label> ' + data.Name, function(r){
                if (r) {
                    $.LoadingOverlay("show", {zIndex: 999});
                    $.ajax({
                        url: window.base_url('store/deleteitem/' + data.Code),
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
            });
        }
    }


    this.showStoreLocations = function()
    {   

        $.LoadingOverlay("show");

        $.get(window.public_url('store/locations')).done(function(response) {
            if (response.status) {

                var $modalObj = $('#addessListModal');
                $modalObj.find('.modal-title').text('Store Locations');
                $modalObj.find('.add-address').attr('id', 'addStoreLocation');

                self.store_locations = response.data;

                if (Object.keys(response.data).length) {
                    var tpl = '<tr><th>Province</th><th>City/Muni</th><th>Barangay</th><th>Street</th><th></th></tr>';

                    $.each(response.data, function(i,e) {
                        tpl += `<tr>
                                    <td>${e.names.Province}</td>
                                    <td>${e.names.MuniCity}</td>
                                    <td>${e.names.Barangay}</td>
                                    <td>${e.Street}</td>
                                    <td style="width:90px;" class="text-center">
                                        <a class="btn btn-sm btn-primary" href="javascript:;" title="Edit" onclick="Store.editStoreLocation(${e.id})"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-sm btn-danger" href="javascript:;" title="Delete" onclick="Store.deleteStoreLocation(${e.id})"><i class="fa fa-trash"></i></a>
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


    this.addStoreLocation = function()
    {   

        var form  = '#storeAddressForm';
        var modal = '#storeAddressModal';
        Utils.show_form_modal(modal, form, 'Add Store Location', function(){
            Utils.set_form_input_value(form, {
                SAddressID       : '',
                SAddressProvince : '',
                SAddressCity     : '',
                SAddressBarangay : '',
                SAddressStreet   : ''
            });
        });

    }

    this.editStoreLocation = function(id)
    {
        var form  = '#storeAddressForm';
        var modal = '#storeAddressModal';

        if (self.store_locations[id] != 'undefined') {
            var address = self.store_locations[id];
            Utils.show_form_modal(modal, form, 'Edit Store Location', function() {
                $(form).find('#SAddressCity').prop('disabled', false);
                $(form).find('#SAddressBarangay').prop('disabled', false);
                Utils.set_form_input_value(form, {
                    SAddressID       : address.id,
                    SAddressProvince : address.Province,
                    SAddressCity     : address.City,
                    SAddressBarangay : address.Barangay,
                    SAddressStreet   : address.Street,
                });

                General.loadCityOptions('#SAddressCity', '#SAddressProvince', '#SAddressBarangay', address.City, function(){
                    General.loadBarangayOptions('#SAddressBarangay', '#SAddressCity', address.Barangay);
                });
            });
        }
    }

    this.deleteStoreLocation = function(id)
    {
        if (self.store_locations[id] != 'undefined') {
            var address = self.store_locations[id];
            bootbox.confirm('Are you sure you want to <label class="label label-danger">remove</label> ' + Object.values(address.names).reverse().join(' ') + ' location?', function(r){
                if (r) {
                    $.LoadingOverlay("show", {zIndex: 999});
                    $.ajax({
                        url: window.base_url('store/delete_location/' + address.id),
                        type: 'GET',
                        success: function (response) {
                            if (response.status) {
                                self.showStoreLocations();
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

}

var Store = new Store();
$(document).ready(function(){
    Store._init();
});