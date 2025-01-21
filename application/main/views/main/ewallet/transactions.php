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
  <h5>My Transactions</h5>
  <?php if (count($records)) { ?>
  <div class="table-responsive">
    <table class="table">
          <thead>
            <th scope="col" class="text-red">Type</th>
            <th scope="col" class="text-red">Merchant</th>
            <th scope="col" class="text-red">RefNo</th>
            <th scope="col" class="text-red">Amount</th>
            <th scope="col" class="text-red">Fee</th>
            <th scope="col" class="text-red">DateTime</th>
            <th scope="col" class="text-red"></th>
          </thead>
          <tbody>
            <?php
            foreach ($records as $i) {
              echo "<tr class='text-left'>";
                echo '<td scope="row">' . lookup('wallet_reward_transaction_type', $i['MerchantType']) . '</td>';
                echo '<td scope="row">' . $i['MerchantName'] . '</td>';
                echo '<td scope="row">' . $i['ReferenceNo'] . '</td>';
                echo '<td scope="row">' . peso($i['Amount']) . '</td>';
                echo '<td scope="row">' . peso($i['ServiceCharge'], true, 4) . '</td>';
                echo '<td scope="row">' . date('m/d/y h:i A', strtotime($i['TransactionDate'])) . '</td>';
                echo '<td scope="row" class="text-right">
                          <button type="button" class="btn btn-sm btn-success" onClick="Wallet.viewRewards('.$i['id'].')"><i class="fa fa-gift"></i> <span class="d-none d-sm-inline">Rewards</span></button>
                          <button type="button" class="btn btn-sm btn-info" onClick="Wallet.viewInvoice('.$i['id'].')"><i class="fa fa-file-text-o"></i> <span class="d-none d-sm-inline">Invoice</span></button>
                      </td>';
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

<script type="text/javascript">
  $(document).ready(function(){
    Wallet.itemData = <?php echo json_encode($records, JSON_HEX_TAG); ?>;
  });
</script>