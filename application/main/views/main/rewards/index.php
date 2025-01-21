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
      <div class="row">
        <div class="col-3 text-center icon-container">
          <a href="<?php echo site_url('ewallet') ?>">
            <img src="<?php echo public_url(); ?>resources/images/icons/wallet.png" />
            <span>eWallet</span>
          </a>
        </div>
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
          <a href="<?php echo site_url('bills') ?>">
            <img src="<?php echo public_url(); ?>resources/images/icons/pay-bills.png" />
            <span>Pay Bills</span>
          </a>
        </div>
      </div>
    </div>
    
  </div>

</div>


<div class="bg-trans-80-white p-3">
  <h5>My Reward Transactions</h5>
  <?php if (count($transactions)) { ?>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th scope="col" class="text-red">From</th>
          <th scope="col" class="text-red">Contact</th>
          <th scope="col" class="text-red">Type</th>
          <th scope="col" class="text-red">Description</th>
          <th scope="col" class="text-red">Amount</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($transactions as $i) {
          echo '<tr>
                  <td scope="row">' . 
                    '<b>' . ($i['from'] ? $i['from']['public_id'] : '<span class="text-danger">ME</span>') . '</b>'
                    . '<br><small class="d-xs-block d-sm-block d-md-inline"> ' . date('m/d/y h:i a', strtotime($i['DateAdded'])) . ' </small>
                  </td>
                  <td>' . ($i['from'] ? $i['from']['contact'] : '') . '<br>' . ($i['from'] ? $i['from']['email'] : '') . '</td>
                  <td>' . lookup('wallet_rewards_type', $i['Type']) .  '</td>
                  <td>' . $i['Description'] .  '</td>
                  <td>' . peso($i['Amount'], true, 4) .  '</td>
                </tr>';
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