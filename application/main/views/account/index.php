<div class="my-account">
			<div class="row gutter-5">
				<div class="col-4 col-sm-3 text-center">
					<img src="<?php echo $profile['photo'] ?>" width="100%" />
					<a href="javascript:;" class="btn btn-sm btn-success small d-block" onclick="Account.editProfile()"><i class="fa fa-pencil"></i> Edit <span class="d-none d-sm-inline">Profile</span></a>
				</div>
				<div class="col-8 col-sm-7">
			     	<div class="balance-info" style="margin-bottom: 5px;display: inline-block;">
				        <p>Balance: <?php echo peso($summary['balance']) ?></p>
				        <p>Total Transactions: <?php echo number_format($summary['transactions']) ?></p>																						
				        <p>Total Debits: <?php echo peso($summary['debit']) ?></p>
				        <p>Total Credits: <?php echo peso($summary['credit']) ?></p>
				    </div>
				    <img class="d-inline-block d-sm-none float-right" src="<?php echo public_url('assets/qr/') . get_qr_file($accountInfo->RegistrationID); ?>" width="100%" style="max-width: 50px;" />
			      <?php
			      if ($accountInfo->agent) {
			      	if ($accountInfo->agent->Status == 0) {
			      		echo '<a href="javascript:;" class="btn btn-sm btn-info small">Delivery agent application on process</a>';
			      	} else {
			      		echo '<div class="text-default">
			      			<input class="deliveryAgentStatusToggle" type="checkbox" '. ($accountInfo->agent->Status == 1 ? 'checked' : '') .' 
		                        data-code="' . $accountInfo->RegistrationID . '"
		                        data-toggle="toggle" 
		                        data-on="Active delivery agent" 
		                        data-off="Inactive delivery agent" 
		                        data-onstyle="success"
		                        data-offstyle="danger"
		                        data-size="mini" 
		                        data-width="100%">
		                       </div>';
			      		echo '<div class="">
			      					<a href="javascript:;" class="mt-1 btn btn-sm btn-info" onclick="General.getDeliveryCoverage()">Covered Area</a>
			      					<a href="'.site_url('account/order_delivery').'" class="mt-1 btn btn-sm btn-warning">Delivery Orders</a>
			      			  </div>';
			      		// echo '<div class="mt-1"><a href="'.site_url('account/order_delivery').'" class="btn btn-sm btn-warning">Delivery Orders</a></div>';
			      	}
			      } else {
			      	echo '<a href="javascript:;" class="btn btn-sm btn-warning small" onclick="Account.applyAsAgent()">Apply as Delivery Agent</a>';
			      }
			      ?>
		    	</div>
				<div class="col-3 col-sm-2 d-none d-sm-block">
					<img src="<?php echo public_url('assets/qr/') . get_qr_file($accountInfo->RegistrationID); ?>" width="100%" />
				</div>
			</div>	
			
			<div class="row main-info">
				<div class="col-12 content">
					<label class="label-info">Name</label>
					<div class="info-field clearfix">
						<span class="text"><?php echo $accountInfo->fullname; ?></span>
						<span class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
					</div>
				</div>
				<div class="col-12 content">
					<label class="label-info">Mobile Number</label>
					<div class="info-field clearfix">
						<span class="text"><?php echo ($accountInfo->DialCode ? '+' . $accountInfo->DialCode . ' - ' : '') . $accountInfo->Mobile ?></span>
						<span class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
					</div>
				</div>
				<div class="col-12 content">
					<label class="label-info">Email Address</label>
					<div class="info-field clearfix">
						<span class="text"><?php echo $accountInfo->EmailAddress ?></span>
						<span class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
					</div>
				</div>
				<div class="col-12 content">
					<label class="label-info">My Bank Name Detail</label>
					<div class="info-field clearfix">
						<span class="text"><?php echo $profile['account_bank_name'] ?></span>
						<span class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
					</div>
				</div>
				<div class="col-12 content">
					<label class="label-info">My Account Number</label>
					<div class="info-field clearfix">
						<span class="text account_no_holder">
							<strong class="text-blue">*****************</strong>
							<strong class="hide text-blue"><?php echo $profile['account_bank_no'] ?></strong>
						</span>
						<a href="javascript:;" class="icon" onclick="Account.toggle_account_no(this)"><strong>SHOW</strong></a>
					</div>
				</div>
				<div class="col-12 content">
					<label class="label-info">Bank Account Name</label>
					<div class="info-field clearfix">
						<span class="text"><?php echo $profile['account_bank_account_name'] ?></span>
						<span class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
					</div>
				</div>
				<!-- Delivery Address for Personal Orders -->
				<div class="col-12 content">
					<label class="label-info">Address</label>
					<div class="info-field clearfix">
						<span class="text"><?php echo $address ? ($address->Street . ', Barangay ' . $address->data['Barangay'] . ', ' . $address->data['MuniCity']) :'' ?></span>
						<a class="icon" href="javascript:;" onclick="General.editUserAddress()"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
					</div>
				</div>
			</div>
			
			<!-- Buttons -->
			<div class="row mt-4 gutter-5">
				<div class="col-4">
					<a href="javascript:;" class="button-shadow secure-my-account"><span>Secure my Account</span></a>
				</div>
				<div class="col-4">
					<a href="<?php echo site_url('connections') ?>" class="button-shadow connection-rewards"><span>Connection Rewards</span></a>
				</div>
				<div class="col-4">
					<a href="<?php echo site_url('ewallet') ?>" class="button-shadow transactions"><span>My Transactions</span></a>
				</div>
			</div>
			<!-- Buttons End -->
			
<!-- 			<div class="row">
				<div class="col-12 mt-3">
					<a href="#" class="button-shadow text-center text-black">
						<img src="library/images/icons/google-icon.png" width="25" />
						Connect with Google
					</a>
				</div>
				
				<div class="col-12 mt-3">
					<a href="#" class="button-blue text-center text-white">
						<img src="library/images/icons/fb-icon.png" width="25" />
						Unlink from Facebook
					</a>
				</div>
			</div> -->
			
			
		</div>


	<?php view('account/modals') ?>
	<?php view('modals/address') ?>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.1/css/intlTelInput.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.1/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.1/js/utils.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <style type="text/css">
      .iti-mobile .iti__country {
        padding: 5px 10px;
      }

      div.toggle.btn.btn-xs {
      	height: 27px !important;
    	padding: 2px 3px;
    	vertical-align: bottom;
    	max-width: 224px;
      }

      label.btn.btn-xs {
    	padding: 2px 3px;
    	cursor: pointer;
      }

    </style>

	<script type="text/javascript">
	  $(document).ready(function(){

	  	Account.info = <?php echo json_encode($profile, JSON_HEX_TAG); ?>;
	  	General.address = <?php echo json_encode($address, JSON_HEX_TAG); ?>;

	  });
	</script>