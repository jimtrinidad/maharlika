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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.1/css/intlTelInput.css" />

    <style type="text/css">
      .iti-mobile .iti__country {
        padding: 5px 10px;
      }

      .iti.iti--allow-dropdown {
        width: 100%;
      }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  
    <title><?php echo TITLE_PREFIX . $pageTitle ?></title>
  
  </head>
  <body class="registration">
    
    <div id="header">
      <a href="<?php echo site_url() ?>" class="login-logo"><img src="<?php echo public_url(); ?>resources/images/login-logo-bg.png?1" width="350" /></a>
    </div>

    <div class="container registration">

      <div class="row mt-5">
        <div class="col-12 col-md-6">
          <h3 class="text-center">Registration</h3>
          <form id="registrationForm" action="<?php echo site_url('account/registration') ?>" autocomplete="false" >
            <input type="hidden" id="RegistrationID" name="RegistrationID" class="form-control" value="<?php echo $RegistrationID; ?>">
            <input type="hidden" name="countryData" id="countryData">
            <div id="error_message_box" class="hide">
              <div class="error_messages alert alert-danger text-danger" role="alert"></div>
            </div>
            <div class="form-group">
              <input type="text" name="Firstname" id="Firstname" class="form-control" placeholder="First name">
            </div>
            <div class="form-group">
              <input type="text" name="Lastname" id="Lastname" class="form-control" placeholder="Last name">
            </div>
            <div class="form-group">
              <input type="text" name="Mobile" id="Mobile" class="form-control">
              <span id="valid-msg" class="hide text-success small"></span>
              <span id="error-msg" class="hide text-danger small"></span>
            </div>
            <div class="form-group">
              <input type="email" name="EmailAddress" id="EmailAddress" class="form-control" placeholder="Email address" readonly onfocus="this.removeAttribute('readonly');">
              <small id="emailHelp" class="form-text">This is required so you can retrieve your password in case you forget it.</small>
            </div>
            <div class="form-group">
              <input type="password" name="Password" id="Password" class="form-control mb-1" placeholder="Password" readonly onfocus="this.removeAttribute('readonly');">
              <input type="password" name="ConfirmPassword" id="ConfirmPassword" class="form-control" placeholder="Confirm Password" readonly onfocus="this.removeAttribute('readonly');">
              <small id="passwordHelp" class="form-text">
                Your password must have: 
                <div class="pl-1 py-1">
                  <!-- <span class="d-block">At lease one uppercase character</span>
                  <span class="d-block">At lease one number</span>
                  <span class="d-block">8 or more characters</span>
                  <span class="d-block">No spaces</span> -->
                  <ul class="mb-0">
                    <li>One uppercase character</li>
                    <li>At least one number</li>
                    <li>8 or more characters</li>
                    <li>No Spaces</li>
                  </ul>
                </div>
              </small>
            </div>
            <div class="form-group">
              <input type="text" name="Referrer" id="Referrer" class="form-control" <?php echo (get_post('r') ? 'readonly' : '') ?> placeholder="Referrer ID" value="<?php echo get_post('r') ?>">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-sm btn-danger btn-block">
                <i class="fa fa-sign-in"></i> <strong>Continue</strong>
              </button>
              <small id="buttonHelp" class="form-text text-muted">By continuing, you accept the <span class="text-danger">Terms and Conditions</span> of ambilis.com</small>
            </div>
            
          </form>
        </div>
        <div class="col-12 col-md-6">
          <div class="px-1">
            <b style="color: #4981c5">Yes it's Free! This is How it Works.</b>
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/4JEuPlwE4pQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>

    </div>

    <?php view('templates/js_constants'); ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-loading-overlay/2.1.6/loadingoverlay.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.1/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.1/js/utils.js"></script>
    <script src="<?php echo public_url(); ?>resources/js/modules/utils.js?<?php echo recache()?>"></script>

    <script type="text/javascript">
      // var input = document.querySelector("#Mobile");
      // var iti = window.intlTelInput(input, {
      //   initialCountry: "PH",
      //   preferredCountries: ["ph", 'bn'],
      //   separateDialCode: true
      // });

      //   errorMsg = document.querySelector("#error-msg"),
      //   validMsg = document.querySelector("#valid-msg");

      // // here, the index maps to the error code returned from getValidationError - see readme
      // var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

      // var reset = function() {
      //   input.classList.remove("error");
      //   errorMsg.innerHTML = "";
      //   errorMsg.classList.add("hide");
      //   validMsg.classList.add("hide");
      // };

      // // on blur: validate
      // input.addEventListener('blur', function() {
      //   reset();
      //   if (input.value.trim()) {
      //     if (iti.isValidNumber()) {
      //       validMsg.classList.remove("hide");
      //     } else {
      //       input.classList.add("error");
      //       var errorCode = iti.getValidationError();
      //       errorMsg.innerHTML = errorMap[errorCode];
      //       errorMsg.classList.remove("hide");
      //     }
      //   }
      // });

      // // on keyup / change flag: reset
      // input.addEventListener('change', reset);
      // input.addEventListener('keyup', reset);
      $(document).ready(function(){
        Account.initializeMobileInput('#Mobile');
      })
    </script>

    <?php
      if (isset($jsModules)) {
        foreach ($jsModules as $jsModule) {
          echo '<script src="'. public_url() .'resources/js/modules/'. $jsModule .'.js?'. recache() .'"></script>';
        }
      }
    ?>
  
  </body>
</html>`