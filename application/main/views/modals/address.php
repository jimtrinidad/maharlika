<div class="modal fade" id="addessListModal" tabindex="-1" role="dialog" aria-labelledby="addessListModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="modal-title text-b-red"></strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-condensed table-bordered address-table-list">
            
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success add-address"><i class="fa fa-plus"></i> Add</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="userAddressModal" tabindex="-1" role="dialog" aria-labelledby="userAddressModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="userAddressForm" name="userAddressForm" class="modalForm" action="<?php echo site_url('account/save_address') ?>">
        <input type="hidden" name="AddressID" id="AddressID">
        <div class="modal-header">
          <strong class="modal-title text-b-red"></strong>
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
                <label class="control-label" for="AddressProvince">Province</label>
                <select id="AddressProvince" name="AddressProvince" class="form-control" onChange="General.loadCityOptions('#AddressCity', this, '#AddressBarangay')">
                  <option value="">--</option>
                  <?php
                    foreach (lookup_all('UtilLocProvince', false, 'provDesc', false) as $v) {
                      echo "<option value='" . $v['provCode'] . "'>" . $v['provDesc'] . "</option>";
                    }
                  ?>
                </select>
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="AddressCity">City/Municipality</label>
                <select id="AddressCity" disabled="disabled" name="AddressCity" class="form-control" onChange="General.loadBarangayOptions('#AddressBarangay', this)">
                  <option value="">--</option>
                </select>
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="AddressBarangay">Barangay</label>
                <select id="AddressBarangay" disabled="disabled" name="AddressBarangay" class="form-control">
                  <option value="">--</option>
                </select>
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="AddressStreet">House Number, Building and Street Name</label>
                <input class="form-control" type="text" name="AddressStreet" id="AddressStreet" placeholder="House Number, Building and Street Name">
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


<div class="modal fade" id="agentDeliveryAddressModal" tabindex="-1" role="dialog" aria-labelledby="agentDeliveryAddressModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: #fff;">
      <form id="agentDeliveryAddressForm" name="agentDeliveryAddressForm" class="modalForm" action="<?php echo site_url('account/save_delivery_coverage') ?>">
        <input type="hidden" name="DAAddressID" id="DAAddressID">
        <div class="modal-header">
          <strong class="modal-title text-b-red"></strong>
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
                <label class="control-label" for="DAAddressProvince">Province</label>
                <select id="DAAddressProvince" name="DAAddressProvince" class="form-control" onChange="General.loadCityOptions('#DAAddressCity', this, '#DAAddressBarangay')">
                  <option value="">--</option>
                  <?php
                    foreach (lookup_all('UtilLocProvince', false, 'provDesc', false) as $v) {
                      echo "<option value='" . $v['provCode'] . "'>" . $v['provDesc'] . "</option>";
                    }
                  ?>
                </select>
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="DAAddressCity">City/Municipality</label>
                <select id="DAAddressCity" disabled="disabled" name="DAAddressCity" class="form-control" onChange="General.loadBarangayOptions('#DAAddressBarangay', this)">
                  <option value="">--</option>
                </select>
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="DAAddressBarangay">Barangay</label>
                <select id="DAAddressBarangay" disabled="disabled" name="DAAddressBarangay" class="form-control">
                  <option value="">All Barangays</option>
                </select>
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


<div class="modal fade" id="storeAddressModal" tabindex="-1" role="dialog" aria-labelledby="storeAddressModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="storeAddressForm" name="storeAddressForm" class="" action="<?php echo site_url('store/save_location') ?>">
        <input type="hidden" name="SAddressID" id="SAddressID">
        <div class="modal-header">
          <strong class="modal-title text-b-red"></strong>
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
                <label class="control-label" for="SAddressProvince">Province</label>
                <select id="SAddressProvince" name="SAddressProvince" class="form-control" onChange="General.loadCityOptions('#SAddressCity', this, '#SAddressBarangay')">
                  <option value="">--</option>
                  <?php
                    foreach (lookup_all('UtilLocProvince', false, 'provDesc', false) as $v) {
                      echo "<option value='" . $v['provCode'] . "'>" . $v['provDesc'] . "</option>";
                    }
                  ?>
                </select>
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="SAddressCity">City/Municipality</label>
                <select id="SAddressCity" disabled="disabled" name="SAddressCity" class="form-control" onChange="General.loadBarangayOptions('#SAddressBarangay', this)">
                  <option value="">--</option>
                </select>
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="SAddressBarangay">Barangay</label>
                <select id="SAddressBarangay" disabled="disabled" name="SAddressBarangay" class="form-control">
                  <option value="">--</option>
                </select>
                <span class="help-block hidden"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="SAddressStreet">Building and Street Name</label>
                <input class="form-control" type="text" name="SAddressStreet" id="SAddressStreet" placeholder="Building and Street Name">
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