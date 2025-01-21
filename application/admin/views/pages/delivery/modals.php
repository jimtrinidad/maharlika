<div class="modal fade" id="updateAgentStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateAgentStatusModal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form id="updateAgentStatusForm" name="updateAgentStatusForm" class="modalForm" action="<?php echo site_url('delivery/save_agent_status') ?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div id="error_message_box" class="hide row">
            <br>
            <div class="error_messages no-border-radius alert alert-danger" role="alert"></div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <label class="control-label">Man Type</label>
                <select class="form-control" id="agent_man_type" name="agent_man_type">
                  <option value=""></option>
                  <?php
                  foreach (lookup('delivery_agent_man_type') as $k => $v) {
                    echo "<option value='{$k}'>{$v}</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <label class="control-label">Status</label>
                <select class="form-control" id="agent_status" name="agent_status">
                  <?php
                  foreach (lookup('delivery_agent_status') as $k => $v) {
                    if ($k > 0) {
                      echo "<option value='{$k}'>{$v}</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <input type="hidden" id="Code" name="Code">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>