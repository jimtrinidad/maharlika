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
		<script src='https://www.google.com/recaptcha/api.js'></script>
	
    <title><?php echo TITLE_PREFIX . $pageTitle ?></title>
	
  </head>
  <body class="login">
		
		<div id="header">
			<a href="<?php echo site_url() ?>" class="login-logo"><img src="<?php echo public_url(); ?>resources/images/login-logo-bg.png" width="350" /></a>
		</div>
		
		<div class="content">

			<div class="main-login container registration">

				<form id="resetPasswordForm" method="post" action="<?php echo site_url('account/reset_password') ?>" autocomplete="off" >

					<div class="row justify-content-center">

						<div class="col-12 col-md-8 form-group">

							<div id="error_message_box" class="hide">
		              <div class="error_messages alert alert-danger text-danger" role="alert"></div>
		          </div>
          
							<h4>Reset Password</h4>
						</div>
						<div class="col-12 col-md-8">
							 <div class="form-group">
	              <input type="password" name="Password" id="Password" class="form-control mb-1" placeholder="Password" readonly onfocus="this.removeAttribute('readonly');">
	              <input type="password" name="ConfirmPassword" id="ConfirmPassword" class="form-control" placeholder="Confirm Password" readonly onfocus="this.removeAttribute('readonly');">
	              <small id="passwordHelp" class="form-text">
	                Your password must have: 
	                <div class="pl-1 py-1">
	                  <ul class="mb-0">
	                    <li>One uppercase character</li>
	                    <li>At least one number</li>
	                    <li>8 or more characters</li>
	                    <li>No Spaces</li>
	                  </ul>
	                </div>
	              </small>
	            </div>
						</div>
					</div>
					
					<div class="row mt-4">
						<div class="col-12 form-group text-center">
							<input type="hidden" name="reset_code" value="<?php echo $reset_code ?>">
							<button type="submit" name="reset_password" class="btn btn-lg bg-l-red text-white mb-3">Reset Password</button>
						</div>
					</div>
				</form>

			</div>
			
		</div>
	
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