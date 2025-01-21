<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary small">

      <div class="box-header">
        <h3 class="box-title">Link Transactions</h3>
        <div class="box-tools">
          <form action="<?php echo site_url('transactions/ecpay') ?>" method="get" class="form-inline">
            <div class="form-group">
              <input type="text" autocomplete="off" id="search_user" name="search_user" value="<?php echo $search_user ?>" class="form-control input-sm" placeholder="Name">
            </div>
            <div class="form-group">
              <input type="text" autocomplete="off" id="search_name" name="search_name" value="<?php echo $search_name ?>" class="form-control input-sm" placeholder="Merchant">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-sm btn-success">Search</button>
            </div>
          </form>
        </div>
      </div>
      <!-- /.box-header -->

      <div class="box-body table-responsive">
        <table class="table table-bordered">
          <thead>
            <th>Name</th>
            <th>Type</th>
            <th>Merchant</th>
            <th>RefNo</th>
            <th>Amount</th>
            <th>Fee</th>
            <th>Commission</th>
            <th>Wallet Deduction</th>
            <th>DateTime</th>
            <th class="c"></th>
          </thead>
          <tbody>
            <?php
            foreach ($records as $i) {
              echo "<tr class='text-left'>";
                echo '<td>' . $i['Firstname'] . ' ' . $i['Lastname'] . '</td>';
                echo '<td>' . lookup('wallet_reward_transaction_type', $i['MerchantType']) . '</td>';
                echo '<td>' . $i['MerchantName'] . '</td>';
                echo '<td>' . $i['ReferenceNo'] . '</td>';
                echo '<td>' . peso($i['Amount']) . '</td>';
                echo '<td>' . peso($i['ServiceCharge'], true, 4) . '</td>';
                echo '<td>' . peso($i['Commission'], true, 4) . '</td>';
                echo '<td>' . peso($i['NetAmount'], true, 2) . '</td>';
                echo '<td>' . date('m/d/y h:i A', strtotime($i['TransactionDate'])) . '</td>';
                echo '<td>
                        <div class="box-tools">
                          <div class="input-group pull-right" style="width: 10px;">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-xs btn-primary" title="Requests Details" onClick="General.viewECData('.$i['id'].',\'ECRequestData\', \'ECpay Transaction Request Data\')"><i class="fa fa-send"></i></button>
                              <button type="button" class="btn btn-xs btn-warning" title="ECPay Response" onClick="General.viewECData('.$i['id'].',\'ECResponseData\', \'ECpay Response\')"><i class="fa fa-book"></i></button>
                              <button type="button" class="btn btn-xs btn-info" onClick="General.viewECData('.$i['id'].',\'InvoiceData\', \'Invoice\')"><i class="fa fa-file-text-o"></i> Invoice</button>
                              <button type="button" class="btn btn-xs btn-success" title="Distributed Rewards" onClick="General.viewECRewards('.$i['id'].')"><i class="fa fa-gift"></i> Rewards</button>
                            </div>
                          </div>
                        </div> 
                      </td>';
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    <!-- /.box-body -->

      <div class="box-footer clearfix">
        <?php echo $pagination ?>
      </div>
    </div>
  </div>
</div>

<?php view('pages/transactions/modals.php'); ?>

<script type="text/javascript">
  $(document).ready(function(){
    General.itemData = <?php echo json_encode($records, JSON_HEX_TAG); ?>;
  });
</script>