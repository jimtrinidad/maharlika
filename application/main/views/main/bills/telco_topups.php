<div class="mt-2">
    <div class="row gutter-5 justify-content-center">
    <?php foreach (lookup('telcos') as $k => $v) { ?>
    	<div class="col-4 mb-2" onclick="Wallet.eloadRequest('<?php echo $k ?>')">
				<div class="rounded bg-white text-center p-1 menu-btn-icon active" title="<?php echo $v ?>">
					<img class="img-fluid" src="<?php echo public_url('resources/images/telco/') . strtolower($k) . '.jpg' ?>" style="max-width: 80%;"/>
					<!-- <h4 class="icon-title text-center pt-2 text-truncate"><?php echo $v ?></h4> -->
				</div>
			</div>
    <?php } ?>
    </div>
</div>

<?php view('main/bills/modals'); ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo public_url(); ?>resources/libraries/select2-bootstrap4.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.full.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){

  	Wallet.itemData = <?php echo json_encode($items, JSON_HEX_TAG); ?>;

  });
</script>