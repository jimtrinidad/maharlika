function Marketplace() {

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

    }


    this.addToCart = function(code)
    {

        $.LoadingOverlay("show", {zIndex: 999});
        $.ajax({
            url: window.base_url('marketplace/add_to_cart'),
            type: 'GET',
            data: {
                'code': code,
                'quantity' : 1
            },
            success: function (response) {
                // console.log(response);
                if (response.status) {
                    $('.cart_items_count').text(response.item_count);
                    $('#addedToCartModal').find('.added_to_cart_message').text(response.message);
                    $('#addedToCartModal').find('.added_to_cart_image').prop('src', public_url('assets/products/') + response.data.Image);
                    $('#addedToCartModal').find('.added_to_cart_name').text(response.data.Name);
                    $('#addedToCartModal').find('.added_to_cart_seller').text(response.data.Seller);
                    $('#addedToCartModal').find('.added_to_cart_price').text(response.data.Price);
                    $('#addedToCartModal').modal({
                        backdrop : 'static',
                        keyboard : false
                    });
                } else {
                    bootbox.alert(response.message);
                }
            },
            complete: function() {
                $.LoadingOverlay('hide');
            }
        });
    }

    this.updateCartItem = function(rowid)
    {   
        $.LoadingOverlay("show", {zIndex: 999});
        var tr = $('#rowid_' + rowid);
        if (tr.length) {
            var qty = tr.find('input.cart_item_qty').val();
            $.ajax({
                url: window.base_url('marketplace/update_cart_item'),
                type: 'GET',
                data: {
                    'rowid': rowid,
                    'quantity' : qty
                },
                success: function (response) {
                    if (response.status) {
                        tr.find('.cart_item_subtotal').text(response.subtotal);
                        $('.cart_total_amount').text(response.total);
                    } else {
                        // bootbox.alert(response.message);
                        tr.find('input.cart_item_qty').val(response.qty);
                    }
                },
                complete: function() {
                    $.LoadingOverlay('hide');
                }
            });
        }
    }

    this.removeCartItem = function(rowid)
    {   
        var tr = $('#rowid_' + rowid);
        if (tr.length) {
            bootbox.confirm('Are you sure you want to remove "' + tr.find('.cart_product_name').text() + '" on your cart?', function(r) {
                if (r) {
                    $.LoadingOverlay("show", {zIndex: 999});
                
                    var qty = tr.find('input.cart_item_qty').val();
                    $.ajax({
                        url: window.base_url('marketplace/remove_cart_item'),
                        type: 'GET',
                        data: {
                            'rowid': rowid
                        },
                        success: function (response) {
                            if (response.status) {
                                tr.remove();
                                $('.cart_total_amount').text(response.total);
                                if (response.item_count == 0) {
                                    location.reload();
                                }
                            } else {
                                bootbox.alert(response.message);
                                $.LoadingOverlay('hide');
                            }
                        },
                        complete: function() {
                            $.LoadingOverlay('hide');
                        }
                    });
                }
            });
        }
    }


    this.placeOrder = function()
    {
        bootbox.confirm('Confirm your order with a total price of <b>'+ $('#total_amount_to_pay').text() +'</b>', function(r) {
            if (r) {
                $.LoadingOverlay("show", {zIndex: 999});
                var params = {};
                params[$global.csrfName] = $global.csrfVal;
                $.ajax({
                    url: window.base_url('marketplace/place_order'),
                    type: 'POST',
                    data: params,
                    success: function (response) {
                        // console.log(response);
                        if (response.status) {
                            $('body').html('');
                            window.location = public_url('order/invoice/' +  response.id);
                        } else {
                            bootbox.alert(response.message);
                        }
                    },
                    complete: function() {
                        $.LoadingOverlay('hide');
                    }
                });
            }
        })
    }

}


var Marketplace = new Marketplace();
$(document).ready(function(){
    Marketplace._init();
});