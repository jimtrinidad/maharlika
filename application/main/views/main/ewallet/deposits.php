<div class="my-account container mb-3">
    
  <div class="row">
    <div class="col-3">
      <img src="<?php echo public_url('assets/profile/') . photo_filename($accountInfo->Photo); ?>" width="100%"/>
    </div>
    <div class="col-6">
      <div class="balance-info">
        <p>Balance: <?php echo peso($summary['balance']) ?></p>
        <p>Total Transactions: <?php echo number_format($summary['transactions']) ?></p>
        <p>Total Debits: <?php echo peso($summary['debit']) ?></p>
        <p>Total Credits: <?php echo peso($summary['credit']) ?></p>
      </div>
    </div>
    <div class="col-3 text-right">
      <img src="<?php echo public_url('assets/qr/') . get_qr_file($accountInfo->RegistrationID); ?>" width="100%" />
    </div>
  </div>

  <div class="account-menu mt-4">
    <div class="header clearfix">
      <span class="text float-left">Balance</span>
      <span class="text float-right"><span class="text-gray">P</span> <?php echo number_format(get_latest_wallet_balance()) ?></span>
    </div>
    
    <div class="content">
      <div class="row justify-content-center">
      <div class="col-3 text-center icon-container">
          <a href="javascript:;" onclick="Wallet.addDeposit()">
            <img src="<?php echo public_url(); ?>resources/images/icons/cashin.png" />
            <span>Fund my Wallet</span>
          </a>
        </div>
        <div class="col-3 text-center icon-container">
          <a href="javascript:;" onclick="Wallet.encashRequest()">
            <img src="<?php echo public_url(); ?>resources/images/icons/encash-money.png" />
            <span>Encash</span>
          </a>
        </div>
        <div class="col-3 text-center icon-container">
          <a href="<?php echo site_url('rewards') ?>">
            <img src="<?php echo public_url(); ?>resources/images/icons/rewards-money.png" />
            <span>Rewards</span>
          </a>
        </div>
        <div class="col-3 text-center icon-container">
          <a href="<?php echo site_url('bills') ?>">
            <img src="<?php echo public_url(); ?>resources/images/icons/pay-bills.png" />
            <span>Pay Bills</span>
          </a>
        </div>
      </div>
    </div>
    
  </div>

  <div class="secondary-account-menu">
    <div class="row mt-4">
      <div class="col-3 icon-container">
        <a href="<?php echo site_url('store') ?>">
          <img src="<?php echo public_url(); ?>resources/images/icons/market-stand.png" class="img-fluid" />
          <span>Business</span>
        </a>
      </div>
      <div class="col-3 icon-container">
        <a href="<?php echo site_url('transactions') ?>">
          <img src="<?php echo public_url(); ?>resources/images/icons/bag.png" class="img-fluid"  />
          <span>Transactions</span>
        </a>
      </div>
      <div class="col-3 icon-container">
        <a href="<?php echo site_url('deposits') ?>">
          <img src="<?php echo public_url(); ?>resources/images/icons/money.png" class="img-fluid"  />
          <span>Deposits</span>
        </a>
      </div>
      <div class="col-3 icon-container">
        <a href="<?php echo site_url('connections') ?>">
          <img src="<?php echo public_url(); ?>resources/images/icons/connections.png" class="img-fluid"  />
          <span>Connections</span>
        </a>
      </div>
    </div>
  </div>
  

</div>


<div class="bg-trans-80-white p-3">
  <div class="float-left"><h5 class="my-1">Fund Logs</h5></div>
  <div class="float-right">
    <a href="javascript:;" onclick="Wallet.addDeposit()">
      <img src="<?php echo public_url(); ?>resources/images/icons/wallet.png" style="max-width: 32px;vertical-align: bottom;"/>
      <span>Add Fund</span>
    </a>
  </div>
  <?php if (count($transactions)) { ?>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th scope="col" class="text-red">Date</th>
          <!-- <th scope="col" class="text-red">TransNo</th> -->
          <th scope="col" class="text-red">ReferenceNo</th>
          <th scope="col" class="text-red">Amount</th>
          <th scope="col" class="text-red">Payment</th>
          <th scope="col" class="text-red">Slip</th>
          <th scope="col" class="text-red">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
            foreach ($transactions as $c) {
              echo "<tr class='text-left' id='deposit_{$c['code']}'>";
                echo '<td scope="row">' . $c['transaction_date'] . '</td>';
                // echo '<td>' . $c['code'] . '</td>';
                echo '<td>' . $c['reference_no'] . '</td>';
                echo '<td>' . peso($c['amount']) . '</td>';
                echo '<td>' . $c['payment'] . '</td>';
                echo '<td>';
                  if ($c['slip']) {
                    echo '<a href="'.public_url('assets/uploads/') . upload_filename($c['slip']).'" data-toggle="lightbox" data-gallery="example-gallery">
                          <img src="'.public_url('assets/uploads/') . upload_filename($c['slip']).'" class="img-fluid" style="max-width:50px;">
                      </a>';
                  }
                echo '</td>';
                echo '<td>';
                if ($c['status_id'] == 0) {
                  echo '<span class="text-warning">'.$c['status'].'</span>';
                } else if ($c['status_id'] == 1) {
                  echo '<span class="text-success">'.$c['status'].'</span><br>';
                  echo $c['completed_date'];
                } else if ($c['status_id'] == 2) {
                  echo '<span class="text-danger">'.$c['status'].'</span>';
                }
                echo '</td>';
              echo '</tr>';
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

<?php view('main/ewallet/modals'); ?>

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