<div class="modal fade" tabindex="-1" id="storeProfileModal" role="dialog" aria-labelledby="storeProfileModal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="storeProfileForm" class="modalForm" action="<?php echo site_url('store/update') ?>">
	    	<div class="modal-header">
	        <h5 class="modal-title text-b-red">Update Store Profile</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
          <div id="error_message_box" class="hide">
            <div class="error_messages alert alert-danger text-danger" role="alert"></div>
          </div>
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="Name" id="Name" placeholder="Store name">
					</div>
					<div class="form-group">
						<label>Contact</label>
						<input type="text" class="form-control" name="Contact" id="Contact" placeholder="Contact">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="Email" id="Email" placeholder="Email">
					</div>
          <div class="form-group">
            <label>Minimum Order Amount</label>
            <input type="number" class="form-control" name="MinimumOrder" id="MinimumOrder" placeholder="Minimum Order Amount">
          </div>
          <div class="form-group">
            <label class="control-label" for="SDProvince">Province</label>
            <select id="SDProvince" name="SDProvince" class="form-control" onChange="General.loadCityOptions('#SDCity', this, '#SDBarangay')">
              <option value="">--</option>
              <?php
                foreach (lookup_all('UtilLocProvince', false, 'provDesc', false) as $v) {
                  echo "<option value='" . $v['provCode'] . "'>" . $v['provDesc'] . "</option>";
                }
              ?>
            </select>
            <span class="help-block hidden"></span>
          </div>
          <div class="form-group">
            <label class="control-label" for="SDCity">City/Municipality</label>
            <select id="SDCity" disabled="disabled"  name="SDCity" class="form-control" onChange="General.loadBarangayOptions('#SDBarangay', this)">
              <option value="">--</option>
            </select>
            <span class="help-block hidden"></span>
          </div>
          <div class="form-group">
            <label class="control-label" for="SDBarangay">Barangay</label>
            <select id="SDBarangay" disabled="disabled" name="SDBarangay" class="form-control">
              <option value="">--</option>
            </select>
            <span class="help-block hidden"></span>
          </div>
          <div class="form-group">
            <label for="Address">Street/Building</label>
            <textarea class="form-control" name="Address" id="Address" placeholder="Street/Building"></textarea>
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


<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModal">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="itemForm" class="modalForm" name="itemForm" action="<?php echo site_url('store/saveitem') ?>">
        <div class="modal-header">
	        <h5 class="modal-title text-b-red">Product Setup</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
        <div class="modal-body">
          <div id="error_message_box" class="hide">
		        <div class="error_messages alert alert-danger text-danger" role="alert"></div>
		      </div>
		      <div class="row pb-4">

		      	<div class="col-6 logo text-center">
              <div class="image-upload-container">
		      			<label class="control-label" for="ProductImage">Product Image</label>
                <img class="image-preview product_image" src="<?php echo public_url(); ?>assets/products/default.png">
                <span class="hiddenFileInput hide">
                  <input type="file" data-default="<?php echo public_url(); ?>assets/products/default.png" accept="image/*" class="image-upload-input" id="product_image" name="Image[ProductImage]"/>
                </span>
              </div>
            </div>
            <div class="col-6 logo text-center">
              <div class="image-upload-container">
            		<label class="control-label" for="PartnerImage">Partner Image</label>
                <img class="image-preview partner_image" src="<?php echo public_url(); ?>assets/products/default.png">
                <span class="hiddenFileInput hide">
                  <input type="file" data-default="<?php echo public_url(); ?>assets/products/default.png" accept="image/*" class="image-upload-input" id="partner_image" name="Image[PartnerImage]"/>
                </span>
              </div>
            </div>

		      </div>
		      <div class="row gutter-5 mt-3">

		      	<div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Name">Product Name</label>
                <input type="text" class="form-control" id="Name" name="Name" placeholder="Product name">
                <span class="form-text text-muted"></span>
              </div>
            </div>
		      	<div class="col-12 col-sm-6">
              <div class="form-group">
                <label class="control-label" for="Manufacturer">Manufacturer / Origin</label>
                <input type="text" class="form-control" id="Manufacturer" name="Manufacturer" placeholder="Manufacturer / Origin">
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label class="control-label" for="ModelName">Model Name</label>
                <input type="text" class="form-control" id="ModelName" name="ModelName" placeholder="Model name">
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Category">Category</label>
                <select class="form-control" id="Category" name="Category" onchange="Store.get_sub_categories(this.value)">
                	<option value=""></option>
                	<?php
                    foreach($categories as $item) {
                      echo '<option value="' . $item['id'] . '">' . $item['Name'] . '</option>';
                    }
                	?>
                </select>
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="SubCategory">Sub Category</label>
                <select class="form-control" id="SubCategory" name="SubCategory">
                </select>
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label class="control-label" for="Price">Unit Price</label>
                <input type="number" class="form-control" id="Price" name="Price" placeholder="Unit price">
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label class="control-label" for="Measurement">Unit of measurement</label>
                <input type="text" class="form-control" id="Measurement" name="Measurement" placeholder="Unit of measurement">
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label class="control-label" for="MinimumQuantity">Minimum Quantity</label>
                <input type="number" class="form-control" id="MinimumQuantity" name="MinimumQuantity" placeholder="Minimum Quantity">
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label class="control-label" for="Stock">Number of Stock</label>
                <input type="number" class="form-control" id="Stock" name="Stock" placeholder="Number of Stock">
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label class="control-label" for="CommissionType">Commission Type</label>
                <select class="form-control" id="CommissionType" name="CommissionType">
                	<option value=""></option>
                	<?php
                    foreach(lookup('commission_type') as $k => $v) {
                      echo '<option value="' . $k . '">' . $v . '</option>';
                    }
                	?>
                </select>
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label class="control-label" for="CommissionValue">Commission Value</label>
                <input type="text" class="form-control" id="CommissionValue" name="CommissionValue" placeholder="Commission">
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-6">
	            <div class="form-group">
	              <label class="control-label" for="DeliveryMethod">Delivery Method</label>
	              <select class="form-control" id="DeliveryMethod" name="DeliveryMethod">
	              	<!-- <option value=""></option> -->
	              	<?php
	                  foreach(lookup('delivery_methods') as $k => $v) {
	                    echo '<option value="' . $k . '">' . $v . '</option>';
	                  }
	              	?>
	              </select>
	              <span class="form-text text-muted"></span>
	            </div>
	          </div>
	          <div class="col-6">
	            <div class="form-group">
	              <label class="control-label" for="Warranty">Warranty</label>
	              <input type="text" class="form-control" id="Warranty" name="Warranty" placeholder="Warranty">
	              <span class="form-text text-muted"></span>
	            </div>
	          </div>
            <div class="col-6">
              <div class="form-group">
                <label class="control-label" for="Weight">Weight</label>
                <input type="number" class="form-control" id="Weight" name="Weight" placeholder="Item Weight">
                <span class="form-text text-muted"></span>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label class="control-label" for="WeightUnit">Weight Unit</label>
                <select class="form-control" id="WeightUnit" name="WeightUnit">
                  <option value=""></option>
                  <?php
                    foreach(lookup('weight_units') as $k => $v) {
                      echo '<option value="' . $k . '">' . $v . '</option>';
                    }
                  ?>
                </select>
                <span class="form-text text-muted"></span>
              </div>
            </div>
	          <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="SearchKeywords">Search Keywords</label>
                <input type="text" class="form-control" id="SearchKeywords" name="SearchKeywords" placeholder="Search Keywords">
                <span class="form-text text-muted small">Type the keyword then press entry to add.</span>
              </div>
            </div>
	          <div class="col-12">
              <div class="form-group">
                <label class="control-label" for="Description">Description</label>
                <textarea class="form-control" id="Description" name="Description" placeholder="Product description"></textarea>
                <span class="form-text text-muted"></span>
              </div>
            </div>

		      </div>

          <input type="hidden" name="Code" id="Code" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn bg-b-red text-white">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>