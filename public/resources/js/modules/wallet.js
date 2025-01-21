function Wallet() {

    // because this is overwritten on jquery events
    var self = this;

    this.itemData = {};
    this.rewardData = false;
    this.payment_outlets = false;
    this.payment_match = false;

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
        var walletForms = $('#paymentForm, #moneyPadalaForm, #encashForm, #eloadForm');
        self.rewardData = false;
        walletForms.submit(function(e) {
            e.preventDefault();
            var _this = this;
            bootbox.confirm({
                message: "CONFIRM TRANSACTION?",
                buttons: {
                    confirm: {
                        label: 'Confirm',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-danger'
                    }
                },
                callback: function (r) {
                    if (r) {
                        Utils.save_form(_this, function(res) {
                            self.rewardData = res.rewards;
                            $(_this).closest('div.modal').modal('hide');
                            $('#successMessageModal .trans-image-header').prop('src', res.image);
                            $('#successMessageModal .trans-message').text(res.message);
                            var table = $('#successMessageModal .transaction-table');
                            table.html('');
                            $.each(res.data, function(i,e) {
                                table.append(`<tr><td>${i}</td><td>${e}</td></tr>`);
                            });

                            if (self.rewardData == false || typeof(self.rewardData) == 'undefined') {
                                $('#successMessageModal .reward-modal-button').hide();
                            } else {
                                $('#successMessageModal .reward-modal-button').show();
                            }

                            $('#successMessageModal').modal({
                                backdrop : 'static',
                                keyboard : false
                            });
                        });
                    }
                }
            });
        });
        

        $('#depositForm').submit(function(e) {
            e.preventDefault();
            var _this = this;
            bootbox.confirm({
                message: "CONFIRM TRANSACTION?",
                buttons: {
                    confirm: {
                        label: 'Confirm',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-danger'
                    }
                },
                callback: function (r) {
                    if (r) {
                        Utils.save_form(_this);
                    }
                }
            });
            e.preventDefault();
        });

        $('#outletPaymentForm').submit(function(e) {
            e.preventDefault();
            var _this = this;
            bootbox.confirm({
                message: "CONFIRM TRANSACTION?",
                buttons: {
                    confirm: {
                        label: 'Confirm',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-danger'
                    }
                },
                callback: function (r) {
                    if (r) {
                        Utils.save_form(_this, function(res){
                            $('#committedPaymentModal #commitRefNo').text(res.data.referenceNo);
                            $('#committedPaymentModal #commitAmount').text(res.data.amount);
                            $('#committedPaymentModal #commitExpiration').text(res.data.expiration);
                            $('#committedPaymentModal').modal({
                                backdrop : 'static',
                                keyboard : false
                            });
                            $('#outletPaymentModal').modal('hide');
                        });
                    }
                }
            });
            e.preventDefault();
        });

        var ajaxReq = null;
        $('#encashForm #Amount').on('keyup change',function() {
            if (ajaxReq != null) ajaxReq.abort();
            ajaxReq =  $.ajax({
                url: window.public_url('get/n2w/' + $(this).val()),
                success: function(response){
                    $('#encashForm').find('.number_in_words').text(response);
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

    this.computePaymentOutletFee = function(elem)
    {
        var fee    = 0;
        var amount = parseInt(elem.value);
        if (amount > 0) {
            fee = Math.round((amount * 0.02), 2);
        } else {
            fee = 0;
        }

        var total = amount + fee;
        
        $('#outletPaymentModal .outletFee').text((fee > 0 ? fee + ' PHP' : ''));
        $('#outletPaymentModal .outletTotal').text((total > 0 ? total + ' PHP' : ''));
    }


    /**
    * add
    */
    this.addDeposit = function()
    {   

        $('#outletPaymentModal').modal('hide');
        var form  = '#depositForm';
        var modal = '#depositModal';
        Utils.show_form_modal(modal, form, false, function(){

        });

    }

    this.payViaOutlet = function()
    {

        $('#depositModal').modal('hide');
        var form  = '#outletPaymentForm';
        var modal = '#outletPaymentModal';
        Utils.show_form_modal(modal, form, false, function(){
            
        });
        
        // reset outlet
        $('.match_outlet_results').html('');
        // get outlet if not set
        if (!self.payment_outlets)
        {
            $.get(window.public_url('get/outlets')).done(function(response) {
                self.payment_outlets = response;
            });
        }
        

    }

    this.findOutlet = function(obj)
    {
        var keyword = $(obj).val();
        var output  = '';
        var match   = 0;
        if(keyword === '')  {
            $('.match_outlet_results').html('');
            $('.outlet_match_count').html('');
            return;
        }

        if(self.payment_match != null) {
            clearTimeout(self.payment_match);
        }
        self.payment_match = setTimeout(function() {
            
            var pattern = '(?=.*' + keyword.split(/\,|\s/).join(')(?=.*') + ')';
            
            $.each(self.payment_outlets, function(i, v) {
                if (v.d.search(new RegExp(pattern,'gi')) != -1) {
                    match += 1;
                    output += `<div class="d-flex flex-row justify-content-between mb-1">
                                <div class="d-flex flex-column p-1">
                                    <p class="mb-1">${v.c}</p> 
                                    <small class="text-muted">${v.d}</small>
                                </div>
                            </div>`;
                }
            });


            $('.match_outlet_results').html(output);
            $('.outlet_match_count').html(match + ' match location(s)');

        },200);

    }

    /**
    * encash
    */
    this.encashRequest = function()
    {   

        var form  = '#encashForm';
        var modal = '#encashModal';
        Utils.show_form_modal(modal, form, false, function(){
            
        });

    }

    /**
    * padala
    */
    this.moneyPadalaRequest = function(id)
    {   

        var data  = self.getData(id);
        if (data) {
            var form  = '#moneyPadalaForm';
            var modal = '#moneyPadalaModal';
            Utils.show_form_modal(modal, form, data.Name, function(){
                $(form).find('#ServiceType').val(data.Code);
                $(form).find('#AccountNo').prop('placeholder', data.FirstField);
                $(form).find('#AccountNoLabel').text(data.FirstField);
                $(form).find('#Identifier').prop('placeholder', data.SecondField);
                $(form).find('#IdentifierLabel').text(data.SecondField);
            });
        }
        // var form  = '#moneyPadalaForm';
        // var modal = '#moneyPadalaModal';
        // Utils.show_form_modal(modal, form, false, function(){

        // });

    }

    /**
    * eload
    */
    this.eloadRequest = function(telco)
    {   

        var form  = '#eloadForm';
        var modal = '#eloadModal';

        if (typeof(self.itemData[telco]) != 'undefined') {
            var data  = self.itemData[telco];
            
            if ($(form).find('#LoadTag').hasClass("select2-hidden-accessible")) {
                $(form).find('#LoadTag').select2('destroy');
            }

            Utils.show_form_modal(modal, form, telco + ' Load Transaction', function(){
                var options = window.emptySelectOption;
                $.each(data, function(i, e){
                    options += `<option data-amount="${e.Denomination}" value="${e.Code}">${e.TelcoTag + ' - P' +e.Denomination}</option>`;
                });
                $(form).find('#LoadTag').html(options).prop('disabled', false).select2({
                    width: 'style',
                    theme: 'bootstrap4',
                    placeholder: $(this).attr('placeholder'),
                }).change(function(){
                    $(form).find('#Amount').val($(this).find('option:selected').data('amount'));
                });
            });
        }

    }


    this.payBills = function(id)
    {

        var data  = self.getData(id);
        if (data) {
            var form  = '#paymentForm';
            var modal = '#paymentModal';
            Utils.show_form_modal(modal, form, data.Description, function(){
                $(form).find('#Biller').val(data.Code);
                $(form).find('#AccountNo').prop('placeholder', data.FirstField).prop('maxlength', data.FirstFieldWidth);
                $(form).find('#AccountNoLabel').text(data.FirstField);
                $(form).find('#Identifier').prop('placeholder', data.SecondField).prop('maxlength', data.SecondFieldWidth);
                $(form).find('#IdentifierLabel').text(data.SecondField);

                if (data.ServiceCharge + 0 > 0) {
                    $(form).find('.con-fee-cont').show();
                    $(form).find('.con-fee').text(data.ServiceCharge);
                } else {
                    $(form).find('.con-fee-cont').hide();
                }
            });
        }
    }

    this.viewInvoice = function(id)
    {
        var data  = self.getData(id);
        if (data) {
            $('#invoiceMessageModal .modal-title').text('Invoice');
            var table = $('#invoiceMessageModal .transaction-table');
            table.html('');
            var items = $.parseJSON(data.InvoiceData);
            if (items) {
                $.each(items, function(i,e) {
                    table.append(`<tr><td>${i}</td><td>${e}</td></tr>`);
                });
            } else {
                table.html(`<tr><td>Not available.</td></tr>`);
            }
            $('#invoiceMessageModal').modal({
                backdrop : 'static',
                keyboard : false
            });
        }
    }

    this.viewRewards = function(id, rewards = false)
    {
        if (id != false) {
            var data  = self.getData(id);
            if (data) {
                rewards = data.Rewards;
            }
        }
        if (rewards) {
            $('#invoiceMessageModal .modal-title').text('Distributed Rewards');
            var table = $('#invoiceMessageModal .transaction-table');
            table.html('');
            if (rewards) {
                $.each(rewards, function(i,e) {
                    table.append(`<tr><td style="border-top: inherit">${e.Type}</td><td style="border-top: inherit">${e.Firstname + ' ' + e.Lastname}</td><td style="border-top: inherit">${e.Amount}</td></tr>`);
                });
            } else {
                table.html(`<tr><td>Not available.</td></tr>`);
            }
            $('#invoiceMessageModal').modal({
                backdrop : 'static',
                keyboard : false
            });
        }
    }

}


var Wallet = new Wallet();
$(document).ready(function(){
    Wallet._init();
});