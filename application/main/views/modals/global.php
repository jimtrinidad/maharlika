<div class="modal fade" id="encashModal" tabindex="-1" role="dialog" aria-labelledby="encashModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="encashForm" name="encashForm" class="modalForm" action="<?php echo site_url('ewallet/encash') ?>">
        <div class="modal-header">
          <strong class="modal-title text-b-red text-center">Encash</strong>
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
                <input class="form-control"  type="number" name="Amount" id="Amount" max="99999999" placeholder="Amount">
                <small class="help-block number_in_words"></small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn bg-b-red text-white">Send to my Debit Card</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="successMessageModal" role="dialog" aria-labelledby="successMessageModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <img class="trans-image-header" width="75">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table transaction-table">
        </table>
        <div class="text-center"><small class="trans-message text-success"></small></div>
      </div>
      <div class="modal-footer reward-modal-button">
        <button type="button" onclick="Wallet.viewRewards(false, Wallet.rewardData)" class="btn btn-info btn-sm"><i class="fa fa-gift"></i> Rewards</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="invoiceMessageModal" role="dialog" aria-labelledby="invoiceMessageModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: #fff;">
      <div class="modal-header">
        <h4 class="modal-title">Invoice</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody class="transaction-table"></tbody>
        </table>
        <div class="text-center"><small class="trans-message text-success"></small></div>
      </div>
    </div>
  </div>
</div>