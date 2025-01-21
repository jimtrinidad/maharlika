<!doctype html>
<html lang="en">
  <head>
  
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?php echo public_url(); ?>resources/images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo public_url(); ?>resources/images/favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap-reboot.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo public_url(); ?>resources/css/style.css?<?php echo recache()?>">
		<link rel="stylesheet" href="<?php echo public_url(); ?>resources/css/site.css">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
    <title><?php echo TITLE_PREFIX . $pageTitle ?></title>
	
  </head>
  <body class="login">
		
		<div id="header">
			<a href="<?php echo site_url() ?>" class="login-logo"><img src="<?php echo public_url(); ?>resources/images/login-logo-bg.png?1" width="350" /></a>
		</div>
		
		<div class="content container">
			<div class="row">
				<div class="col-md-6">
					<div class="px-1">
						<div class="row">
							<div class="col-6">
								<a href="<?php echo site_url('account/signup') ?>" class="btn btn-block bg-cream btn-auth"><img src="<?php echo public_url(); ?>resources/images/icons/fb-icon.png" width="20" />  <span>Continue with Facebook</span></a>
							</div>
							<div class="col-6">
								<a href="<?php echo site_url('account/signup') ?>" class="btn btn-block bg-cream btn-auth"><img src="<?php echo public_url(); ?>resources/images/icons/google-icon.png" width="20" /> <span>Continue with Google</span></a>
							</div>
						</div>

						<form id="loginForm" action="<?php echo site_url('account/login') ?>" autocomplete="off" >
							<div class="row">
								<div class="col-12 text-center my-3">
									<strong class="text-b-red">OR</strong>
								</div>
							</div>
							<div id="error_message_box" class="hide alert alert-danger text-danger" role="alert"></div>
							<div class="row">
								<div class="col-12 form-group">
									<input type="text" class="form-control bg-cream" placeholder="Email" id="username" name="username" />
								</div>
								<div class="col-12 form-group">
									<input type="password" class="form-control bg-cream" placeholder="Password" id="password" name="password" />
								</div>
								<div class="col-12 form-group text-right">
									<a href="<?php echo site_url('account/forgot') ?>">Forgot Password</a>
								</div>
							</div>
							
							<div class="row">
								<div class="col-12 form-group text-center">
									<button type="submit" class="btn btn-lg bg-l-red text-white mb-3">LOGIN</button>
									<p><span class="text-gray">If you are a new user,</span> <a href="<?php echo site_url('account/signup') ?>" class="text-b-red">Signup here</a></p>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-6">
					<div class="px-1">
						<b style="color: #4981c5">Yes it's Free! This is How it Works.</b>
						<div class="embed-responsive embed-responsive-16by9">
						  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/4JEuPlwE4pQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
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