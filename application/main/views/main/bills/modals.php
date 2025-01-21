<div class="modal fade" id="paymentModal" role="dialog" aria-labelledby="paymentModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="paymentForm" name="paymentForm" class="modalForm" action="<?php echo site_url('ewallet/bill') ?>">
        <input type="hidden" name="Biller" id="Biller">
        <div class="modal-header">
          <strong class="modal-title text-b-red"><?php echo $pageTitle ?></strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="error_message_box" class="hide">
            <div class="error_messages alert alert-danger text-danger" role="alert"></div>
          </div>
          <div class="row p-2">
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" id="AccountNoLabel" for="AccountNo"></label>
                <input class="form-control" required type="text" name="AccountNo" id="AccountNo" placeholder="">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" id="IdentifierLabel" for="Identifier"></label>
                <input class="form-control" required type="text" name="Identifier" id="Identifier" placeholder="">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Amount">Amount</label>
                <input class="form-control" required type="number" step=".01" name="Amount" id="Amount" placeholder="Amount">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12 con-fee-cont">
              <span class="text-danger small">Merchant Service Charge: <b class="con-fee">4.00</b></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Pay</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="moneyPadalaModal" tabindex="-1" role="dialog" aria-labelledby="moneyPadalaModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="moneyPadalaForm" name="moneyPadalaForm" class="modalForm" action="<?php echo site_url('ewallet/money_padala') ?>">
        <input type="hidden" name="ServiceType" id="ServiceType">
        <div class="modal-header">
          <strong class="modal-title text-b-red">Money Padala</strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="error_message_box" class="hide">
            <div class="error_messages alert alert-danger text-danger" role="alert"></div>
          </div>
          <div class="row gutter-5">
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" id="AccountNoLabel" for="AccountNo">Account Number</label>
                <input class="form-control" required  type="text" name="AccountNo" id="AccountNo" placeholder="Account Number">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" id="IdentifierLabel" for="Identifier">Identifier</label>
                <input class="form-control" required  type="text" name="Identifier" id="Identifier" placeholder="Identifier">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Amount">Amount</label>
                <input class="form-control" required type="number" step=".01" name="Amount" id="Amount" placeholder="Amount">
                <span class="help-block hidden"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn bg-b-red text-white">Request</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="eloadModal" role="dialog" aria-labelledby="eloadModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="eloadForm" name="eloadForm" class="modalForm" action="<?php echo site_url('ewallet/eload') ?>">
        <div class="modal-header">
          <strong class="modal-title text-b-red text-center">Telco eLoad</strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="error_message_box" class="hide">
            <div class="error_messages alert alert-danger text-danger" role="alert"></div>
          </div>
          <div class="row gutter-5">
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="LoadTag">Load Type</label>
                <select class="form-control" id="LoadTag" name="LoadTag" required>
                </select>
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Number">11 Digits Number</label>
                <input class="form-control"  type="text" required maxlength="11" name="Number" id="Number" placeholder="11 Digits Number">
                <span class="help-block hidden"></span>
              </div>
            </div>
<!--             <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Amount">Amount</label>
                <input class="form-control" readonly="" type="number" name="Amount" id="Amount" placeholder="Amount">
                <span class="help-block hidden"></span>
              </div>
            </div> -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Send a Load</button>
        </div>
      </form>
    </div>
  </div>
</div>