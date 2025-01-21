<h3>Store Profile</h3>
<?php if ($StoreData) { ?>
  <h1><?php echo $StoreData->Name ?? ''; ?></h1>
  <hr class="my-2">
  <p class="lead">
  <?php echo $StoreData->Address ?? ''; ?>
  <span class="d-block"><?php echo $StoreData->Contact ?? ''; ?></span>
  <span class="d-block"><?php echo $StoreData->Email ?? ''; ?></span>
  </p>
<?php } else { echo '<h4 class="text-danger">You need to setup your store profile first.</h4>'; } ?>
<button class="btn btn-info" onClick="Store.updateProfile()">Update</button>

<hr>

<div class="row">
  <div class="col-8"><h3>Products</h3></div>
  <div class="col-4 text-right">
    <button class="btn btn-sm btn-success" onClick="Store.addProduct()"><i class="fa fa-plus"></i> Add</button>
  </div>
</div>
<div class="row">
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
            <th scope="col">Commission</th>
            <th scope="col">Commission Value</th>
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
              echo '<td>' . $i['CommissionType'] . '</td>';
              echo '<td>' . $i['CommissionValue'] . '</td>';
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

<?php view('main/store/modals'); ?>

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