<div class="modal fade" id="orderStatusModal" tabindex="-1" role="dialog" aria-labelledby="orderStatusModal">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form id="orderStatusForm" name="orderStatusForm" class="modalForm" action="<?php echo site_url('orders/update_status') ?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Update order status</h4>
        </div>
        <div class="modal-body">
          <div id="error_message_box" class="hide row">
            <br>
            <div class="error_messages no-border-radius alert alert-danger" role="alert"></div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <label class="control-label">Status</label>
                <select class="form-control" id="order_status" name="order_status">
                  <?php
                  foreach (lookup('order_status') as $k => $v) {
                    echo "<option value='{$k}'>{$v}</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <label class="control-label">Remarks</label>
                <textarea class="form-control" id="status_remarks" name="status_remarks" placeholder="Remarks"></textarea>
              </div>
            </div>
          </div>
          <input type="hidden" id="Code" name="Code">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="viewOrderStatusModal" tabindex="-1" role="dialog" aria-labelledby="viewOrderStatusModal" style="/*z-index: 1041;*/">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content" style="background: #fff;">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          <p class="text-bold">Order Progress</p>
          <hr>
          <div class="order_status_cont"></div>
        </div>
    </div>
  </div>
</div>