<div class="my-account">
	<div class="row gutter-5">
		<div class="col-4 col-sm-3 text-center">
			<img src="<?php echo public_url('assets/profile/') . photo_filename($accountInfo->Photo); ?>" width="100%" />
		</div>
		<div class="col-8 col-sm-7">
	     	<div class="balance-info" style="margin-bottom: 5px;display: inline-block;">
		        <p>Balance: <?php echo peso($summary['balance']) ?></p>
		        <p>Total Transactions: <?php echo number_format($summary['transactions']) ?></p>																						
		        <p>Total Debits: <?php echo peso($summary['debit']) ?></p>
		        <p>Total Credits: <?php echo peso($summary['credit']) ?></p>
		    </div>
		    <img class="d-inline-block d-sm-none float-right" src="<?php echo public_url('assets/qr/') . get_qr_file($accountInfo->RegistrationID); ?>" width="100%" style="max-width: 50px;" />
    	</div>
		<div class="col-3 col-sm-2 d-none d-sm-block">
			<img src="<?php echo public_url('assets/qr/') . get_qr_file($accountInfo->RegistrationID); ?>" width="100%" />
		</div>
	</div>	

	<div class="row">
		<div class="col-12">
			<div class="bg-trans-80-white mt-3">
			  <h5>Orders</h5>
			  <?php if (count($orders)) { ?>
			  <div class="table-responsive">
			    <table class="table">
			      <thead>
			        <tr>
			          <th scope="col" class="text-red" style="min-width: 100px;">Name</th>
			          <th scope="col" class="text-red">Contact</th>
			          <th scope="col" class="text-red" style="min-width: 120px;">Address</th>
			          <th scope="col" class="text-red">Order ID</th>
			          <th scope="col" class="text-red">DeliveryReward</th>
			          <th scope="col" class="text-red">Status</th>
			          <th scope="col" class="text-red"></th>
			        </tr>
			      </thead>
			      <tbody>
			        <?php
			        foreach ($orders as $i) {

			        	$class = '';
			        	$txt_class = '';
			        	if ($i['Status'] == 4) {
			        		$class = 'bg-light';
			        		$txt_class = 'text-success';
			        	} else if ($i['Status'] == 3) {
			        		$class = 'bg-light';
			        		$txt_class = 'text-info';
			        	}
			          	echo '<tr class="' . $class . '">
			                  <td scope="row"><b>' . $i['user']['name'] . '</b><br/><small class="d-xs-block d-sm-block d-md-inline"> ' . date('m/d/y H:i', strtotime($i['DateOrdered'])) . ' </small></td>
			                  <td>' . $i['user']['mobile'] . '<br>' . $i['user']['email']  . '</td>
			                  <td>' . $i['Address']['Street'] . ' <br>' . implode(', ', array_reverse($i['Address']['Names'])) .  '</td>
			                  <td>' . $i['Code'] .  '</td>
			                  <td>' . peso($i['Distribution']['delivery'], true, 2) .  '</td>
			                  <td class="' . $txt_class . '">' . lookup('order_status', $i['Status']) .  '</td>
			                  <td>
			                  	<a class="btn btn-info btn-sm m-1" href="'.site_url('account/order_delivery_detail/' . $i['Code']).'">Details</a>';

			                if ($i['Status'] <= 2) {
			                  	echo '<a class="btn btn-success btn-sm m- text-white" onClick="Account.markDelivered('. $i['Code'] .')">Delivered</a>';
			                } else if ($i['Status'] <= 4) {
			                	echo '<a class="btn btn-success btn-sm m- text-white" onClick="Account.viewOrderStatus('. $i['Code'] .')">Receipt</a>';
			                }

			            echo   '</td>
			                </tr>';
			        }
			        ?>
			      </tbody>
			    </table>
			  </div>
			  <?php 
			    } else {
			      echo '<h3>No record found.</h3>';
			    } 
			  ?>
			  
			</div>
		</div>
	</div>
	
</div>

<?php view('account/modals') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
  })
</script>