<div class="modal fade" id="partnerOutletModal" tabindex="-1" role="dialog" aria-labelledby="partnerOutletModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="partnerOutletForm" class="modalForm" name="partnerOutletForm" action="<?php echo site_url('outlets/update') ?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><b>Partner Outlet</b></h4>
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
                  <label class="control-label" for="Name">Name</label>
                  <input type="text" class="form-control" id="Name" name="Name" placehoder="Name">
                  <span class="help-block hidden"></span>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="form-group">
                  <label class="control-label" for="Address">Address</label>
                  <textarea class="form-control" id="Address" name="Address" placehoder="Address"></textarea>
                  <span class="help-block hidden"></span>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="form-group">
                  <label class="control-label" for="Province">Province</label>
                  <select id="Province" name="Province" class="form-control" onChange="General.loadCityOptions('#City', this, '#Barangay')">
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
              <div class="col-xs-12">
                <div class="form-group">
                  <label class="control-label" for="City">City/Municipality</label>
                  <select id="City" disabled="disabled" name="City" class="form-control" onChange="General.loadBarangayOptions('#Barangay', this)">
                    <option value="">--</option>
                  </select>
                  <span class="help-block hidden"></span>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="form-group">
                  <label class="control-label" for="Barangay">Barangay</label>
                  <select id="Barangay" disabled="disabled" name="Barangay" class="form-control">
                    <option value="">--</option>
                  </select>
                  <span class="help-block hidden"></span>
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