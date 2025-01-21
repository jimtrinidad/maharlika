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
  <h5>eWallet Logs</h5>
  <?php if (count($transactions)) { ?>
  <div class="table-responsive">
    <table class="table">
      <tbody>
        <?php
        foreach ($transactions as $i) {
          echo '<tr>';
            echo '<td scope="row">';
              if ($i['Type'] == 'Credit') {
                echo '<i class="fa fa-external-link-square text-green" aria-hidden="true"></i> ';
              } else {
                echo '<i class="fa fa-external-link-square text-red rotate" aria-hidden="true"></i> ';
              }
              echo $i['Description'] . '<br>';
              echo '<small>' . date('m/d/y h:i a', strtotime($i['Date'])) . '</small>';
            echo '</td>';
            if ($i['Type'] == 'Credit') {
              echo '<td><i class="fa fa-plus text-green" aria-hidden="true"></i> ' . peso($i['credit'], true, 4) . '</td>';
            } else {
              echo '<td><i class="fa fa-minus text-red" aria-hidden="true"></i> ' . peso($i['debit'], true, 4) . '</td>';
            }
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php 
    } else {
      echo '<h3>No transaction found.</h3>';
    } 
  ?>
  
</div>

<?php view('main/ewallet/modals'); ?>