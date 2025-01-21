<div class="my-account container mb-3">
			<div class="row">
			
				<div class="col-6">
					<div class="balance-info">
						<strong class="text-b-red"><?php echo strtoupper($userData->Lastname . ', ' . $userData->Firstname) ?></strong>
						<p class="text-bold">CONTACT DETAILS</p>
						<p><?php echo $userData->Mobile; ?></p>
						<p><?php echo $userData->EmailAddress; ?></p>
						<br />
						<p class="text-bold">DELIVERY ADDRESS</p>
						<p><?php echo $address->Street . ', Barangay ' . $address->data['Barangay']; ?>, </p>
						<p><?php echo $address->data['MuniCity'] . ', ' . $address->data['Province']; ?></p>
						<br />
						<?php if ($agent) { ?>
						<p class="text-bold">DELIVERY AGENT</p>
						<div>
							<div class="d-inline-block float-left">
								<img src="<?php echo public_url('assets/profile/') . $agent->photo ?>" class="img-fluid" style="max-width: 60px;">
							</div>
							<div class="d-inline-block float-left ml-2">
								<p class="text-bold text-info"><?php echo $agent->name; ?></p>
								<p><a href="tel:<?php echo $agent->mobile; ?>" ><i class="fa fa-mobile"></i> <?php echo $agent->mobile; ?></a></p>
								<p><a href="javascript:;" onclick="Chatbox.openChatbox('<?php echo $agent->id ?>')"><i class="fa fa-envelope"></i> Send a message</a></p>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="col-6 text-right balance-info">
					<img src="<?php echo public_url('assets/qr/') . get_qr_file($orderData->Code); ?>" width="100" />
					<p class="text-bold mt-2">TRANSACTION # <?php echo $orderData->Code ?></p>
					<p><strong>ORDER DATE:</strong> <?php echo date('F d, Y', strtotime($orderData->DateOrdered)) ?></p>
					<p><strong>STATUS:</strong> <?php echo lookup('order_status', $orderData->Status) ?></p>
					<p><strong>PAYMENT:</strong> <?php echo lookup('payment_method', $orderData->PaymentMethod) ?></p>
				</div>
			</div>	
			<hr/>	
			<div class="header clearfix">
				<h5 class="text-bold float-left">Total Order</h5>
				<h5 class="text float-right"><?php echo peso($orderData->TotalAmount) ?></h5>
			</div>
			

			
		</div>

		
			<div class="table-responsive">
				<table class="table">
				  <thead>
					<tr>
					  <th scope="col" class="text-red">YOUR ORDER</th>
					  <th scope="col" class="text-red">QTY</th>
					  <th scope="col" class="text-red">PRICE</th>
					  <th scope="col" class="text-red">CASHBACK</th>
					  <th scope="col" class="text-red">DISCOUNT</th>
					</tr>
				  </thead>
				  <tbody>
				  	<?php
				  	foreach ($items as $item) {
				  		$distribution = json_decode($item['Distribution']);
				  		echo '<tr>
									  <th scope="row">' . $item['ItemName'] . '</th>
									  <td>' . $item['Quantity'] . '</td>
									  <td>' . peso($item['Price']) . '</td>
									  <td>' . $distribution->cashback . '</td>
									  <td>' . $distribution->discount . '</td>
									</tr>';
				  	}
				  	?>
				  </tbody>
				</table>
			</div>
			
			<hr/>
		<div class="container my-account">	
			<div class="row balance-info">
				<div class="col-6">
					<p><strong>TOTAL QUANTITY: </strong> <?php echo $orderData->ItemCount ?></p>
					<p><strong>TOTAL CASHBACK: </strong> <?php echo peso($orderData->Distribution->cashback) ?></p>
				</div>
				<div class="col-6 text-right">
					<p><strong>TOTAL DISCOUNT: </strong> <?php echo peso($orderData->Distribution->discount) ?></p>
					<p><strong>TOTAL: </strong> <?php echo peso($orderData->TotalAmount) ?></p>
				</div>
			</div>
		</div>