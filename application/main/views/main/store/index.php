<div class="mobile-menu-top container">
		
	<div class="mobile-menu-info">
		<div class="row gutter-5">
			<div class="col-3 col-sm-2">
				<img src="<?php echo public_url('assets/profile/') . photo_filename($accountInfo->Photo); ?>" width="100%"/>
			</div>
			<div class="col-9 col-sm-10">
				<?php if ($StoreData) { ?>
				  <h4 class="mb-0"><?php echo $StoreData->Name ?? ''; ?></h4>
				  <p class="lead small mb-2">
				  <span class="d-block"><img class="i-15" src="<?php echo public_url(); ?>resources/images/icons/location.png" /> <?php echo $address ?? ''; ?></span>
				  <span class="d-block"><img class="i-15" src="<?php echo public_url(); ?>resources/images/icons/call.png" /> <?php echo $StoreData->Contact ?? ''; ?></span>
				  <span class="d-block"><img class="i-15" src="<?php echo public_url(); ?>resources/images/icons/email.png" /> <?php echo $StoreData->Email ?? ''; ?></span>
				  </p>
				  <?php 
					  	if ($StoreData->Status == 0) { 
					  		echo '<b class="text-warning">Store is pending for approval</b>';
					  	} else if ($StoreData->Status == 2) {
					  		echo '<b class="text-danger">Store was disabled. Please contact Amblis.com support for details.</b>';
					  	}

				  	} else { echo '<b class="text-danger">You need to setup your store profile and get approved first before you can sell your products.</b>'; }
				  ?>
			</div>
		</div>
	</div>
	
	<div class="account-menu mt-3">
		<div class="header clearfix">
			<span class="text float-left">All Store Sales</span>
			<span class="text float-right"><span class="text-gray">P</span> <?php echo number_format(0) ?></span>
		</div>
		
		<div class="content">
			<div class="row justify-content-center">
				<div class="col text-center icon-container">
					<a href="javascript:;" onClick="Store.updateProfile()">
						<img src="<?php echo public_url(); ?>resources/images/icons/shop.png" class="i-45" />
						<span>Update Profile</span>
					</a>
				</div>
				<?php if ($StoreData && $StoreData->Status == 1) { ?>
				<div class="col text-center icon-container">
					<a href="javascript:;" onClick="Store.addProduct()">
						<img src="<?php echo public_url(); ?>resources/images/icons/basket.png" class="i-45" />
						<span>Sell Product or Service</span>
					</a>
				</div>
				<div class="col text-center icon-container">
					<a href="javascript:;" onclick="Store.showStoreLocations()">
						<img src="<?php echo public_url(); ?>resources/images/icons/map.png" class="i-45" />
						<span>Store Locations</span>
					</a>
				</div>
				<?php } ?>
				<div class="col text-center icon-container">
					<a href="javascript:;">
						<img src="<?php echo public_url(); ?>resources/images/icons/cart.png" class="i-45" />
						<span>Sales Order</span>
					</a>
				</div>
				<div class="col text-center icon-container">
					<a href="javascript:;">
						<img src="<?php echo public_url(); ?>resources/images/icons/sales-report.png" class="i-45" />
						<span>Sales Report</span>
					</a>
				</div>
			</div>
		</div>
		
	</div>
	
</div>

<?php 
	// if ($StoreData && $StoreData->Status == 1) { 
	if (count($items)) {
?>

<div class="row mt-2">
	<div class="col-12"><h4>Products</h4></div>
  <div class="col-12">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col" style="width: 50px"></th>
            <th scope="col">Name</th>
            <th scope="col">Category</th>
            <th scope="col">Price</th>
            <th scope="col">UoM</th>
            <th scope="col">Commission Type</th>
            <th scope="col">Commission</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $categories = lookup_db('ProductCategories', 'Name');
          foreach ($items as $i) {
            echo '<tr>';
              echo '<th scope="row"><img class="img-thumbnail" style="max-width:40px;max-height: 40px;" src="' . public_url('assets/products/') . product_filename($i['Image']) . '"></th>';
              echo '<td>' . $i['Name'] . '</td>';
              echo '<td>' . ($categories[$i['Category']] ?? '') . '</td>';
              echo '<td>' . peso($i['Price']) . '</td>';
              echo '<td>' . $i['Measurement'] . '</td>';
              echo '<td>' . ($i['CommissionType'] ? lookup('commission_type', $i['CommissionType']) : '') . '</td>';
              echo '<td>' . floatval($i['CommissionValue']) . '</td>';
              echo '<td class="text-right">
                    <a href="javascript:;" onclick="Store.editProduct('. $i['id'] . ')" class="text-info"><i class="fa fa-pencil"></i></a>
                    <a href="javascript:;" onclick="Store.deleteProduct('. $i['id'] . ')" class="text-danger"><i class="fa fa-trash"></i></a>
                    </td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php } ?>

<?php view('main/store/modals'); ?>
<?php view('modals/address') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.min.js"></script>
<link rel="stylesheet" href="<?php echo public_url('resources/libraries/tagsinput')?>tagsinput.css" />
<script src="<?php echo public_url('resources/libraries/tagsinput')?>tagsinput.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		Store.profile = <?php echo json_encode($StoreData, JSON_HEX_TAG); ?>;
    Store.itemData = <?php echo json_encode($items, JSON_HEX_TAG); ?>;
    Store.categories = <?php echo json_encode($categories, JSON_HEX_TAG); ?>;
    Store.sub_categories = <?php echo json_encode($sub_categories, JSON_HEX_TAG); ?>;
	});
</script>