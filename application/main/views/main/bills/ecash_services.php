<form id="searchBiller" action="<?php echo site_url('padala') ?>" method="get">
  <div class="row text-center mb-4">
    <div class="col-md-12 float-none center-block">
      <div class="input-group">
        <input type="text" name="search" class="form-control bg-cream" placeholder="Find" value="<?php echo get_post('search') ?>">
        <div class="input-group-append" id="button-addon4">
        <button class="btn bg-green text-white" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        </div>
      </div>  
    </div>
  </div>
</form>

<div class="mt-2">
    <?php
    if (count($items)) {
    ?>
      <div class="row gutter-5 justify-content-center">
      <?php foreach ($items as $item) { ?>
      	<div class="col-3 mb-2" onclick="Wallet.moneyPadalaRequest('<?php echo $item['id'] ?>')">
					<div class="rounded bg-white text-center p-1 menu-btn-icon active" title="<?php echo $item['Description'] ?>">
						<img class="img-fluid" src="<?php echo public_url('assets/logo/') . $item['Image'] ?>" style="max-width: 80%;"/>
						<h4 class="icon-title text-center pt-2 text-truncate"><?php echo $item['Name'] ?></h4>
					</div>
				</div>
      <?php } ?>
      </div>
    <?php
    } else {
        echo '<div class="row"><div class="col-sm-12"><h4 class="h4">No record found.</h4></div></div>';
    }
    ?>
</div>

<?php view('main/bills/modals'); ?>

<script type="text/javascript">
  $(document).ready(function(){

  	Wallet.itemData = <?php echo json_encode($items, JSON_HEX_TAG); ?>;

  });
</script>