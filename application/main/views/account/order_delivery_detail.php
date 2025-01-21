<div class="my-account">
	<div class="row">
		<div class="col-6">
			<div class="balance-info">
				<p><?php echo date('F d, Y', strtotime($orderData->DateOrdered)) ?></p>
				<strong class="text-b-red"><?php echo strtoupper($orderData->user->name) ?></strong>
				<p class="text-bold">CONTACT DETAILS</p>
				<p><?php echo $orderData->user->email; ?></p>
				<p><a href="tel:<?php echo $orderData->user->mobile; ?>" ><i class="fa fa-mobile"></i> <?php echo $orderData->user->mobile; ?></a></p>
				<p><a href="javascript:;" onclick="Chatbox.openChatbox('<?php echo $orderData->user->user_id ?>')"><i class="fa fa-envelope"></i> Send a message</a></p>
				<br />
				<p class="text-bold">DELIVERY ADDRESS</p>
				<p><?php echo $orderData->Address->Street . ', Barangay ' . $orderData->Address->Names->Barangay; ?>, </p>
				<p><?php echo $orderData->Address->Names->MuniCity . ', ' . $orderData->Address->Names->Province; ?></p>
				<br />
			</div>
		</div>
		<div class="col-6 text-right balance-info">
			<img src="<?php echo public_url('assets/qr/') . get_qr_file($orderData->Code); ?>" width="100" />
			<p class="text-bold mt-2">TRANSACTION # <?php echo $orderData->Code ?></p>
			<p><strong>STATUS:</strong> <?php echo lookup('order_status', $orderData->Status) ?></p>
			<p><strong>PAYMENT:</strong> <?php echo lookup('payment_method', $orderData->PaymentMethod) ?></p>

			<?php
			if ($orderData->Status <= 2) {
              	echo '<br><a class="btn btn-success btn-sm m- text-white" onClick="Account.markDelivered('. $orderData->Code .')">Delivered</a>';
            }
			?>
		</div>
	</div>

	<hr/>

	<h5 class="text-bold float-left">Items</h5>

	<div class="table-responsive">
		<div class="card bg-light px-2 py-1 rounded-0">
			<div class="row gutter-5">
				<div class="col-6">Items</div>
				<div class="col-3 text-center">Quantity</div>
				<div class="col-3 text-center">Supplier Price</div>
			</div>
		</div>
		<?php
		$total = 0;
		foreach ($store_items as $store) {
			echo '<div class="card bg-light px-2 py-1 mt-2 rounded-0 small">';
				echo '<div class="mb-2">
						<a class="text-bold text-info" href="javascript:;">'. $store['name'] . '</a>
						<p class="lead small mb-2">
						  <span class="d-block">' . $store['address']['street'] . implode(', ', $store['address']['names']) . '</span>
						  <span class="d-block">' . $store['contact'] . '</span>
						  <span class="d-block">' . $store['email'] . '</span>
						 </p>
					</div>';
				$x = 0;
				foreach ($store['items'] as $i) {
				if ($x++ > 0) {
				echo '<span class="border-top my-2"></span>';
				}
				?>
				<div class="row gutter-5 mb-1">
					<div class="col-6">
						<div class="float-left" style="width: 80px;"><img src="<?php echo public_url('assets/products/') . product_filename($i['itemData']->Image); ?>" style="width: 60px;height: auto;" class="img-responsive" /></div>
						<div class="pt-3">
							<b class="nomargin cart_product_name"><?php echo $i['ItemName']; ?></b>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="col-3 text-center">Qty: <b><?php echo $i['Quantity']; ?></b></div>
					<div class="col-3 text-center">
						<?php 
						$sub_total = $i['Distribution']->supplier_price * $i['Quantity'];
						$total += $sub_total;
						echo peso($sub_total); 
						?>
					</div>
				</div>
				<?php
				}
			echo '</div>';
		}
		?>
	</div>

	<hr/>

	<div class="header clearfix">
		<h5 class="text-bold float-left">Total Price</h5>
		<h5 class="text float-right"><?php echo peso($total) ?></h5>
	</div>

</div>

<?php view('account/modals') ?>