<?php
$results = $this->appdb->getRecords('ProductCategories', array(), 'Name');
$categories = array();
foreach ($results as $c) {
    $sub = $this->appdb->getRecords('ProductSubCategories', array('CategoryID' => $c['id']), 'Name');
    $c['subCategories'] = array();
    foreach ($sub as $s) {
        $c['subCategories'][$s['id']] = $s;
    }
    $categories[$c['id']] = $c;
}

?>
<div id="mobile-menu">
		
	<div class="menu-icon">
		<div></div>
		<div></div>
		<div></div>
	</div>

	<?php echo ($pageSubTitle ?? 'Ambilis Mobile Platform'); ?>
	
	<div class="dropmenu">
		<ul class="m-0 p-0">
			<li>
				<a href="javascript:;" data-toggle="dropdown" class="nav-link dropdown-toggle"><img src="<?php echo public_url(); ?>resources/images/menu/cat.png"/>Categories</a>
        <ul class="dropdown-menu dropdown-menu-left">
        	<?php
        	echo '<li class="dropdown-item">
		                <a href="'. site_url('marketplace') .'">All Categories</a>
		            </li>';
        	foreach ($categories as $c) {
        	?>
            <li class="dropdown-item dropdown-submenu">
            	<?php if (count($c['subCategories'])) { ?>
                <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle"><?php echo $c['Name'] ?></a>
                <ul class="dropdown-menu">
                	<?php
                		echo '<li class="dropdown-item">
				                        <a href="'. site_url('marketplace?c=' . $c['id']) .'">All '. $c['Name'] .'</a>
				                    </li>';
                		foreach ($c['subCategories'] as $sc) {
                			echo '<li class="dropdown-item">
				                        <a href="'. site_url('marketplace?c=' . $c['id'] . '&sc=' . $sc['id']) .'">'. $sc['Name'] .'</a>
				                    </li>';
                		}
                	?>
                </ul>
              <?php 
            	} else {
              	echo '<a href="' . site_url('marketplace?c=' . $c['id']) . '">'. $c['Name'] .'</a>';
              } 
              ?>
            </li>
          <?php } ?>
        </ul>
			</li>
			<li><a href="<?php echo site_url('brands')?>"><img src="<?php echo public_url(); ?>resources/images/menu/star.png"/>Brands</a></li>
			<li><a href="<?php echo site_url('marketplace')?>"><img src="<?php echo public_url(); ?>resources/images/menu/marketplace.png"/>Marketplace</a></li>
			<?php if (!isGuest()) { ?>
			<li><a href="<?php echo site_url('account')?>"><img src="<?php echo public_url('assets/profile/') . photo_filename($accountInfo->Photo); ?>"/>My Account</a></li>
			<li><a href="<?php echo site_url('ewallet')?>"><img src="<?php echo public_url(); ?>resources/images/menu/ewallet.png"/>eWallet</a></li>
			<li><a href="<?php echo site_url('rewards')?>"><img src="<?php echo public_url(); ?>resources/images/menu/rewards.png"/>Rewards</a></li>
			<li><a href="<?php echo site_url('connections')?>"><img src="<?php echo public_url(); ?>resources/images/menu/conn.png"/>Connections</a></li>
			<li><a href="<?php echo site_url('bills')?>"><img src="<?php echo public_url(); ?>resources/images/menu/bills.png"/>Bills Payment</a></li>
			<li><a href="<?php echo site_url('ticket')?>"><img src="<?php echo public_url(); ?>resources/images/menu/ticket.jpg"/>Ticket Payment</a></li>
			<li><a href="<?php echo site_url('government')?>"><img src="<?php echo public_url(); ?>resources/images/menu/govt.png"/>Government Payment</a></li>
			<li><a href="<?php echo site_url('padala')?>"><img src="<?php echo public_url(); ?>resources/images/menu/money-transfer.png"/>Money Padala</a></li>
			<li><a href="<?php echo site_url('eload')?>"><img src="<?php echo public_url(); ?>resources/images/menu/eload.png"/>eLoad</a></li>
			<li><a href="<?php echo site_url('store')?>"><img src="<?php echo public_url(); ?>resources/images/menu/mybusiness.png"/>My Business</a></li>
			<li><a href="<?php echo site_url('amcloud')?>"><img src="<?php echo public_url(); ?>resources/images/menu/rewards.png"/>Ambilis Cloud</a></li>
			<li><a href="<?php echo site_url('support')?>"><img src="<?php echo public_url(); ?>resources/images/menu/support.png"/>Support</a></li>
			<li><a href="<?php echo site_url('howitworks')?>"><img src="<?php echo public_url(); ?>resources/images/menu/how.png"/>How it Works</a></li>
			<li><a href="<?php echo site_url('terms')?>"><img src="<?php echo public_url(); ?>resources/images/menu/terms.png"/>Terms & Conditions</a></li>
			<?php } ?>
		</ul>
	</div>

	<div class="menu_cart_button">
		<a href="<?php echo site_url('marketplace/' . ($this->cart->total_items() > 0 ? 'cart' : '')) ?>" class="btn btn-sm bg-red text-white rounded" type="button"><span class="badge badge-warning cart_items_count"><?php echo $this->cart->total_items() ? $this->cart->total_items() : ''; ?></span><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>

		<a href="<?php echo site_url() ?>" class="btn btn-sm bg-red text-white rounded" type="button">
			<i class="fa fa-home" aria-hidden="true"></i>
		</a>

	</div>

</div>

<script type="text/javascript">
		$(document).ready(function(){
			$('.menu-icon').click(function(){
				$('.dropmenu').toggle();
			});
		});
	</script>