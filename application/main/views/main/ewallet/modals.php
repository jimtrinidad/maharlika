<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="depositModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="depositForm" name="depositForm" class="modalForm" action="<?php echo site_url('ewallet/add_deposit') ?>">
        <div class="modal-header">
          <strong class="modal-title text-b-red">Fund My Wallet</strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row gutter-5">
            <div class="col-6">
              <button type="button" class="btn btn-secondary btn-block" disabled onclick="Wallet.addDeposit()">Via Transfer</button>
            </div>
            <div class="col-6">
              <button type="button" class="btn btn-success btn-block" onclick="Wallet.payViaOutlet()">Via Payment Outlet</button>
            </div>
          </div>
          <hr class="p-2">
          <div id="error_message_box" class="hide">
            <div class="error_messages alert alert-danger text-danger" role="alert"></div>
          </div>
          <div class="row gutter-5">
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Bank">Payment Partner</label>
                <input class="form-control" type="text" name="Bank" id="Bank" placeholder="Payment Partner">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Branch">Location</label>
                <input class="form-control"  type="text" name="Branch" id="Branch" placeholder="Location">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="ReferenceNo">Control / Transaction No.</label>
                <input class="form-control"  type="text" name="ReferenceNo" id="ReferenceNo" placeholder="Control/Transaction No.">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label class="control-label" for="Date">Transaction Date</label>
                <input class="form-control"  type="date" name="Date" id="Date" placeholder="Transaction Date">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label class="control-label" for="Amount">Fund Amount</label>
                <input class="form-control"  type="number" step=".01" name="Amount" id="Amount" placeholder="0">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <label class="control-label" for="Amount">Screenshot / Deposit Slip</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">Image</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="Photo" name="Photo" accept="image/*">
                  <label class="custom-file-label text-truncate" for="valid_id_two">Browse</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row gutter-5">
            <div class="col-12">
              <?php
              $setting = $this->appdb->getRowObject('Settings', 'fund_wallet_instruction', 'key');
              if ($setting) {
                echo $setting->value;
              }
              ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn bg-b-red text-white">Add Fund</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade outletPayment" id="outletPaymentModal" tabindex="-1" role="dialog" aria-labelledby="outletPaymentModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="outletPaymentForm" name="outletPaymentForm" class="modalForm" action="<?php echo site_url('ewallet/commit_load_payment') ?>">
        <div class="modal-header">
          <strong class="modal-title text-b-red">Fund My Wallet on Payment Outlet</strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="row gutter-5">
            <div class="col-6">
              <button type="button" class="btn btn-success btn-block" onclick="Wallet.addDeposit()">Via Transfer</button>
            </div>
            <div class="col-6">
              <button type="button" class="btn btn-secondary btn-block" disabled onclick="Wallet.payViaOutlet()">Via Payment Outlet</button>
            </div>
          </div>
          <hr class="p-2">
          <div id="error_message_box" class="hide">
            <div class="error_messages alert alert-danger text-danger" role="alert"></div>
          </div>
          <div class="row gutter-5">
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Amount">Enter amount you want to add on your wallet.</label>
                <input class="form-control" style="padding: 20px 10px;font-size: 40px;font-weight: bold;"  type="number" min="0" max="50000" step=".01" name="Amount" id="Amount" placeholder="0" onkeyup="Wallet.computePaymentOutletFee(this)">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Remarks">Remarks</label>
                <input class="form-control"  type="text" name="Remarks" id="Remarks" placeholder="Remarks">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group bottom-line">
                <div class="control-label float-left label">Partner outlet estimated fee.</div>
                <div class="float-right outletFee"></div>
                <div class="clearfix"></div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group bottom-line">
                <div class="control-label float-left label">Estimated amount to pay.</div>
                <div class="float-right outletTotal" style="font-weight: bold;font-size: 20px;"></div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <div class="divider"></div>
          <div class="row gutter-5">
            <div class="col-12">
              <small>
                <p>Pay at any of our payment outlets using your order reference number what will be issue upon submission.</p>
              </small>
              <span class="hide badge badge-info font-weight-normal">
                Check avialable payment outlets <a class="font-weight-bold text-warning" href="http://www.ecpay.com.ph/partner-outlet-finder" target="_blank">HERE</a>
              </span>
            </div>
          </div>
          <div class="row gutter-5">
            <div class="col-12 p-2">
              <label class="control-label" for="">Cash in parter outlets</label>
              <div class="input-group mb-2">
                <input type="text" placeholder="Find outlet by name or location" class="form-control outlet_finder" onkeyup="Wallet.findOutlet(this)">
                <div class="input-group-append"><button type="button" class="btn btn-primary" onclick="Wallet.findOutlet('#outletPaymentModal .outlet_finder')"><i class="fa fa-search"></i></button></div>
              </div> 
              <span class="text mb-4 outlet_match_count"></span>
              <div class="match_outlet_results"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn bg-b-red text-white">Next</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade outletPayment" id="committedPaymentModal" tabindex="-1" role="dialog" aria-labelledby="committedPaymentModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body">
          <div class="row gutter-5">
            <div class="col-12 text-center">
              <p>
                <h3>Complete your payment</h3>
              </p>
              <p>
                Complete your payment within 24 hours (<b><span id="commitExpiration"></span></b>).
              </p>
              <p>
                Pay at any of our payment outlets using the details below.<br><br>
                Merchant name: <b>AMBILIS MOBILE CREDITS</b><br>
                Reference number: <b><span id="commitRefNo"></span></b><br>
                Amount: <b>PHP: <span id="commitAmount"></span></b>
              </p>
              <p>
              Check the nearest <a class="font-weight-bold" href="http://www.ecpay.com.ph/partner-outlet-finder" target="_blank">payment outlets</a> in your area.
              </p>
            </div>
          </div>

          <div class="row gutter-5">
            <div class="col-12 p-2">
              <label class="control-label" for="">Cash in parter outlets</label>
              <div class="input-group mb-2">
                <input type="text" placeholder="Find outlet by name or location" class="form-control outlet_finder" onkeyup="Wallet.findOutlet(this)">
                <div class="input-group-append"><button type="button" class="btn btn-primary" onclick="Wallet.findOutlet('#committedPaymentModal .outlet_finder')"><i class="fa fa-search"></i></button></div>
              </div> 
              <span class="text mb-4 outlet_match_count"></span>
              <div class="match_outlet_results"></div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>