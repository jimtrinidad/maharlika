<!doctype html>
<html lang="en">
  <head>
  
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap-reboot.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo public_url(); ?>resources/css/style.css?<?php echo recache()?>">
		<link rel="stylesheet" href="<?php echo public_url(); ?>resources/css/site.css">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
    <title><?php echo TITLE_PREFIX . $pageTitle ?></title>
	
  </head>
  <body class="">
		
		<div id="header">
			<a href="#" class="login-logo"><img src="<?php echo public_url(); ?>resources/images/login-logo-bg.png" width="350" /></a>
		</div>
		
		<?php echo $templateContent;?>
	
		<?php view('templates/js_constants'); ?>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-loading-overlay/2.1.6/loadingoverlay.min.js"></script>
		<script src="<?php echo public_url(); ?>resources/js/modules/utils.js?<?php echo recache()?>"></script>

		<?php
	    if (isset($jsModules)) {
	      foreach ($jsModules as $jsModule) {
	        echo '<script src="'. public_url() .'resources/js/modules/'. $jsModule .'.js?'. recache() .'"></script>';
	      }
	    }
	  ?>
	
  </body>
</html>`