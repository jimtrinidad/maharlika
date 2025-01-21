function Products() {

    // because this is overwritten on jquery events
    var self = this;

    // initialize module variables
    this.categoryData = {}

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

        $('.storeStatusToggle').change(function(e){
            self.updateStoreStatus(this);
        });

    }

    /**
    * usage of different libraries and plugins
    */
    this.set_configs = function()
    {
        
    }

    /**
    * show/hide department children
    */
    this.toggleSubCategories = function(id)
    {
        $('#cat_' + id).toggleClass('hidden');
    }

    this.getCategory = function(id)
    {   

        if (typeof(this.categoryData[id]) != 'undefined') {
            return this.categoryData[id];
        }

        return false;
    }

    this.getSubCategory = function(parentID, subID)
    {   

        if (this.getCategory(parentID) != false) {
            if (typeof(this.getCategory(parentID).subCategories[subID]) != 'undefined') {
                return this.getCategory(parentID).subCategories[subID];
            }
        }

        return false;
    }

    this.addCategory = function()
    {   

        var form  = '#categoryForm';
        var modal = '#categoryModal';
        Utils.show_form_modal(modal, form, 'Add Product Category', function(){
            $(form).find('.image-preview').prop('src', window.public_url() + 'assets/uploads/default.png');
        });

    }

    this.editCategory = function(id)
    {   
        var data = this.getCategory(id);

        console.log(data);
        if (data) {
            var form  = '#categoryForm';
            var modal = '#categoryModal';
            Utils.show_form_modal(modal, form, 'Update Product Category', function(){
                Utils.set_form_input_value(form, data);
                $(form).find('.image-preview').prop('src', window.public_url() + 'assets/uploads/default.png');
                if (data.Image) {
                    $(form).find('.image-preview').prop('src', window.public_url() + 'assets/uploads/' + data.Image);
                }
            });
        }
    }

    this.deleteCategory = function(id)
    {   
        var data = self.getCategory(id);
        if (data) {
            bootbox.confirm('Are you sure you want to <label class="label label-danger">delete</label> ' + data.Name, function(r){
                if (r) {
                    $.LoadingOverlay("show", {zIndex: 999});
                    $.ajax({
                        url: window.base_url('product/delete_category/' + data.Code),
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


    this.addSubCategory = function(parentID)
    {   

        var parentData  = this.getCategory(parentID);
        if (parentData) {
            var form  = '#subCategoryForm';
            var modal = '#subCategoryModal';
            Utils.show_form_modal(modal, form, 'Add Product Category', function(){
                $(form).find('#CategoryID').val(parentID);
                $(form).find('.image-preview').prop('src', window.public_url() + 'assets/uploads/default.png');
            });
        }

    }

    this.editSubCategory = function(parentID, subID)
    {   
        var data        = this.getSubCategory(parentID, subID);
        var parentData  = this.getCategory(parentID);

        if (data) {
            var form  = '#subCategoryForm';
            var modal = '#subCategoryModal';
            Utils.show_form_modal(modal, form, 'Update Product Category', function(){
                Utils.set_form_input_value(form, data);
                $(form).find('.image-preview').prop('src', window.public_url() + 'assets/uploads/default.png');
                if (data.Image) {
                    $(form).find('.image-preview').prop('src', window.public_url() + 'assets/uploads/' + data.Image);
                }
            });
        }
    }

    this.deleteSubCategory = function(parentID, subID)
    {   
        var data        = self.getSubCategory(parentID, subID);
        if (data) {
            bootbox.confirm('Are you sure you want to <label class="label label-danger">delete</label> ' + data.Name, function(r){
                if (r) {
                    $.LoadingOverlay("show", {zIndex: 999});
                    $.ajax({
                        url: window.base_url('product/delete_sub_category/' + data.Code),
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


    this.approveStore = function(code)
    {
        var tr = $('#store_' + code);
        if (tr.length) {
            var name   = tr.find('td:nth(1)').text();
            var store   = tr.find('td:nth(3)').text();
            bootbox.confirm({
                message  : `Are you sure you want to <label class="label label-success">enable</label> <b>${store}</b> of ${name}?`,
                buttons: {
                    confirm: {
                        label: 'Enable',
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
                            url: window.base_url('product/approve_store/' + code),
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

    this.updateStoreStatus = function(elem)
    {
        var checkbox    = $(elem);
        var data        = checkbox.data();
        var status      = checkbox.is(":checked");
        $.ajax({
            url: window.base_url('product/store_status/' + data.code),
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

}


var Products = new Products();
$(document).ready(function(){
    Products._init();
});