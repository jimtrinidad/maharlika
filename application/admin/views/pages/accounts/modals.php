<div class="modal fade" id="updateAccountModal" tabindex="-1" role="dialog" aria-labelledby="updateAccountModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="updateAccountForm" class="modalForm" name="updateAccountForm" action="<?php echo site_url('accounts/update_account') ?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><b>Accounts</b> | Update</h4>
        </div>
        <div class="modal-body">
          <div id="error_message_box" class="hide row">
            <br>
            <div class="error_messages no-border-radius alert alert-danger" role="alert"></div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="accountInfoCont hidden col-xs-12 col-sm-3 padding-top-10 text-center">
                <img style="width: 100px;height: 100px;margin: 10px auto" class="photo" src="">
              </div>
              <div class="accountInfoCont accountInfo hidden col-xs-12 col-sm-9 padding-top-10"></div>
            </div>
            <div class="row padding-top-20">
              <div class="col-xs-12">
                <div class="form-group">
                  <label class="control-label" for="AccountLevel">Account Level</label>
                  <select id="AccountLevel" name="AccountLevel" class="form-control">
                    <?php
                    foreach (lookup('account_level') as $k => $v) {
                      echo "<option value='{$k}'>{$v}</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <input type="hidden" id="id" name="id">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>