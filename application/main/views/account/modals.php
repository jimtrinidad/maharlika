<div class="modal fade" id="updateProfileModal" tabindex="-1" role="dialog" aria-labelledby="updateProfileModal">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <form id="updateProfileForm" name="updateProfileForm" class="modalForm" action="<?php echo site_url('account/save_profile') ?>">
        <input type="hidden" name="user_id" id="user_id">
        <input type="hidden" name="countryData" id="countryData">
        <div class="modal-header">
          <strong class="modal-title text-b-red">Update Profile</strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="error_message_box" class="hide">
            <div class="error_messages alert alert-danger text-danger" role="alert"></div>
          </div>

          <div class="row gutter-5">
            <div class="col-4 logo text-center">
              <div class="image-upload-container">
                <img class="image-preview" src="<?php echo public_url(); ?>assets/profile/default.jpg">
                <span class="hiddenFileInput hide">
                  <input type="file" data-default="<?php echo public_url(); ?>assets/profile/default.jpg" accept="image/*" class="image-upload-input" id="account_photo" name="account_photo"/>
                </span>
              </div>
            </div>
            <div class="col-8">
              <div class="row gutter-5">
                <div class="col-12">
                  <div class="form-group">
                    <label class="control-label" for="account_firstname">Firstname</label>
                    <input type="text" class="form-control" name="account_firstname" id="account_firstname" placeholder="Firstname">
                    <span class="help-block hidden"></span>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label class="control-label" for="account_lastname">Lastname</label>
                    <input type="text" class="form-control" name="account_lastname" id="account_lastname" placeholder="Lastname">
                    <span class="help-block hidden"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row gutter-5">
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="account_mobile">Mobile</label>
                <input type="text" name="account_mobile" id="account_mobile" class="form-control">
                <span id="valid-msg" class="hide text-success small"></span>
                <span id="error-msg" class="hide text-danger small"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="account_email">Email address</label>
                <input type="email" name="account_email" id="account_email" class="form-control" placeholder="Email address" readonly onfocus="this.removeAttribute('readonly');">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="account_bank_name">Bank name</label>
                <input type="text" class="form-control" name="account_bank_name" id="account_bank_name" placeholder="Bank name">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="account_bank_no">Account Number</label>
                <input type="text" class="form-control" name="account_bank_no" id="account_bank_no" placeholder="Account number">
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="account_bank_account_name">Account Name</label>
                <input type="text" class="form-control" name="account_bank_account_name" id="account_bank_account_name" placeholder="Account name">
                <span class="help-block hidden"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn bg-b-red text-white">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="deliveryAgentApplicationModal" tabindex="-1" role="dialog" aria-labelledby="deliveryAgentApplicationModal">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <form id="deliveryAgentApplicationForm" name="deliveryAgentApplicationForm" class="modalForm" action="<?php echo site_url('account/delivery_agent_application') ?>">
        <input type="hidden" name="user_id" id="user_id">
        <div class="modal-header">
          <strong class="modal-title text-b-red">Apply as Delivery Agent</strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <p class="h5">Earn as much as 2000 pesos per 20 completed transaction.</p>
          <p>You just need to provide some documents for your application</p>

          <div id="error_message_box" class="hide">
            <div class="error_messages alert alert-danger text-danger" role="alert"></div>
          </div>

          <div class="row gutter-5">
            <div class="col-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">1st ID</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="valid_id_one" name="file[valid_id_one]" accept="image/*">
                  <label class="custom-file-label text-truncate" for="valid_id_one">Choose file</label>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">2nd ID</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="valid_id_two" name="file[valid_id_two]" accept="image/*">
                  <label class="custom-file-label text-truncate" for="valid_id_two">Choose file</label>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">Police Clearance</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="file[police_clearance]"  id="police_clearance" accept="image/*">
                  <label class="custom-file-label text-truncate" for="police_clearance">Choose file</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row gutter-5">
            <div class="col-12">
              <small>Note: All attachment should be an image format.</small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn bg-b-red text-white">Apply</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="setDeliveredOrderModal" tabindex="-1" role="dialog" aria-labelledby="setDeliveredOrderModal">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <form id="setDeliveredOrderForm" name="setDeliveredOrderForm" class="modalForm" action="<?php echo site_url('account/set_order_delivered') ?>">
        <input type="hidden" name="order_id" id="order_id">
        <div class="modal-header">
          <strong class="modal-title text-b-red">Set Order as Delivered</strong>
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
                <label class="control-label" for="file">Receipt / Acknowledgement</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">Image</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="file" name="file" accept="image/*">
                  <label class="custom-file-label text-truncate" for="file">Choose file</label>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Remarks">Remarks</label>
                <textarea class="form-control" id="Remarks" name="Remarks" rows="2"></textarea>
                <span class="help-block hidden"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success text-white">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal" id="orderStatusModal" tabindex="-1" role="dialog" aria-labelledby="orderStatusModal" style="/*z-index: 1041;*/">
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