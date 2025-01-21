<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Deposit Requests</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table id="tableData" class="table table-hover">
          <thead>
            <tr>
              <th>Code</th>
              <th>Depositor</th>
              <th>Transaction No</th>
              <th>Transaction Date</th>
              <th>Amount</th>
              <th>Payment Center</th>
              <th>Location</th>
              <th>Sceenshot</th>
              <th class="c">Verified Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($records as $c) {
              echo "<tr class='text-left' id='deposit_{$c['Code']}'>";
                echo '<td>' . $c['Code'] . '</td>';
                echo '<td>' . $c['accountData']['Firstname'] . ' ' . $c['accountData']['Lastname'] . '</td>';
                echo '<td>' . $c['ReferenceNo'] . '</td>';
                echo '<td>' . $c['TransactionDate'] . '</td>';
                echo '<td>' . peso($c['Amount']) . '</td>';
                echo '<td>' . $c['Bank'] . '</td>';
                echo '<td>' . $c['Branch'] . '</td>';
                echo '<td>';
                  if ($c['Photo']) {
                    echo '<a href="'.public_url('assets/uploads/' . upload_filename($c['Photo'])).'" data-toggle="lightbox" data-gallery="example-gallery">
                          <img src="'.public_url('assets/uploads/' . upload_filename($c['Photo'])).'" class="img-fluid logo-smaller">
                      </a>';
                  }
                echo '</td>';
                echo '<td>';
                if ($c['Status'] == 0) {
                  echo   '<div class="box-tools">
                          <div class="input-group pull-right" style="width: 10px;">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-xs btn-success" onClick="Wallet.confirmDeposit('.$c['Code'].')"><i class="fa fa-check"></i> Verify</button>
                              <button type="button" class="btn btn-xs btn-danger" onClick="Wallet.declineDeposit('.$c['Code'].')"><i class="fa fa-ban"></i> Decline</button>
                            </div>
                          </div>
                        </div>';
                } else if ($c['Status'] == 1) {
                  echo date('m/d/y h:i a', strtotime($c['VerifiedDate']));
                } else if ($c['Status'] == 2) {
                  echo '<span class="text-danger">Declined</span>';
                }
                echo '</td>';
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>

<?php view('pages/product/modals.php'); ?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    Delivery.agents = <?php echo json_encode($records, JSON_HEX_TAG); ?>;
  })
</script>