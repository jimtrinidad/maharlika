<!doctype html>
<html lang="en">
  <head>
  
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<link rel="shortcut icon" href="<?php echo public_url(); ?>resources/images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo public_url(); ?>resources/images/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo TITLE_PREFIX . $pageTitle ?></title>
    
    <?php if (isset($pageMeta)) {echo $pageMeta;} ?>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap-reboot.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo public_url(); ?>resources/css/style.css?<?php echo recache()?>">
		<link rel="stylesheet" href="<?php echo public_url(); ?>resources/css/site.css?<?php echo recache()?>">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
  </head>
  <body>
		
			
		<!-- Header -->
		<div id="header">
			<a href="<?php echo site_url()?>"><img src="<?php echo public_url(); ?>resources/images/ambilis-bills.png?1" /></a>
		</div>
	  <!-- Header End -->

	  <?php view('templates/menu'); ?>
				
			<!-- Main Body -->
			<div id="main-content" class="<?php echo ($pageClass ?? '') ?>">
				<div class="container p-0">
					<div class="rounded p-1 pt-2">
						<?php echo $templateContent;?>
					</div>
				</div>
			</div>
			<!-- Main Body End -->

		<?php if (!isGuest()) { ?>
		<div id="footer" class="user-logged-in text-center text-white p-3">
			Hi <a href="#"><?php echo $accountInfo->Firstname?>!</a> Welcome to your Mobile Business Menu. <br>Not you? <a href="<?php echo site_url('account/logout') ?>">Logout</a>
			<br>
			<small>Referral Link: <span class="text-primary"><?php echo site_url('u/' . $accountInfo->PublicID) ?></span></small>
			<?php if ($accountInfo->StoreID) { ?>
				<small style="display: block;line-height: 1">Store Link: <span class="text-primary"><?php echo site_url('business/' . $accountInfo->StoreID) ?></span></small>
			<?php } ?>
		</div>



		<?php 
		// DELIVERY NOTIFICATION
		if (isset($accountInfo->new_delivery_order) && $accountInfo->new_delivery_order) { 
		?>
	    <div class="modal" id="neworderModal" tabindex="-1" role="dialog" aria-labelledby="neworderModal" style="/*z-index: 1041;*/">
		  <div class="modal-dialog modal-md modal-dialog-centered">
		    <div class="modal-content" style="background: #fff;">
		      	<div class="modal-body">
		      		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			            <span aria-hidden="true">&times;</span>
			        </button>
	      			<p class="text-bold text-success">We have found you a Client!</p>
	      			<hr>
		      		<?php foreach ($accountInfo->new_delivery_order as $i) { ?>
						<div class="order-info">
							<div class="d-inline-block float-left">
								<img src="<?php echo public_url('assets/profile/') . $i->photo ?>" class="img-fluid" style="max-width: 60px;">
							</div>
							<div class="d-inline-block float-left ml-2"  style="width: calc(100% - 70px)">
								<p class="text-bold text-info"><?php echo $i->name; ?></p>
								<small>
									<p><?php echo $i->address; ?></p>
									<div class="float-left">
									<p><a href="tel:<?php echo $i->mobile; ?>" ><i class="fa fa-mobile"></i> <?php echo $i->mobile; ?></a></p>
									<p><a href="javascript:;" onclick="Chatbox.from_delivery_notif = true;Chatbox.openChatbox('<?php echo $i->user_id ?>')"><i class="fa fa-envelope"></i> Send a message</a></p>
									</div>
								</small>
							</div>
							<a style="margin-top: -31px;" href="<?php echo site_url('account/order_delivery_detail/' . $i->order_code) ?>" class="text-white float-right btn btn-info btn-sm">Open</a>
							<div class="clearfix"></div>
						</div>
						<hr>
		      		<?php } ?>
		      	</div>
		    </div>
		  </div>
		</div>
		<style type="text/css">
			#neworderModal .modal-body .order-info p {
				padding: 0;
				margin: 0;
			}
			#neworderModal .modal-body p a {
				text-decoration: none;
				cursor: pointer;
				color: #0e6c9c;
			}
		</style>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#neworderModal').modal({
		            backdrop : 'static',
		            // keyboard : false
		        });

				
			})
		</script>
		<?php } ?>

		<?php view('snippets/chat'); ?>
		<?php } ?>

		<?php view('templates/js_constants'); ?>
		<?php view('modals/global'); ?>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo public_url(); ?>resources/libraries/bootbox.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-loading-overlay/2.1.6/loadingoverlay.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
		<script src="<?php echo public_url(); ?>resources/js/modules/utils.js?<?php echo recache()?>"></script>
		<script src="<?php echo public_url(); ?>resources/js/modules/wallet.js?<?php echo recache()?>"></script>

		<?php
	      if (isset($jsModules)) {
	        foreach ($jsModules as $jsModule) {
	          echo '<script src="'. public_url() .'resources/js/modules/'. $jsModule .'.js?'. recache() .'"></script>';
	        }
	      }
	    ?>
	
  </body>
</html>