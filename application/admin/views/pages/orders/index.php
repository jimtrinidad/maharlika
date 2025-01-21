<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Orders</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table id="tableData" class="table table-hover">
          <thead>
            <tr>
              <th>Order No</th>
              <th>Buyer</th>
              <th>Payment</th>
              <th>ItemCount</th>
              <th>Amount</th>
              <th>Company</th>
              <th>DeliveryAgent</th>
              <th>Date</th>
              <th>Status</th>
              <th class="c"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($records as $c) {
              $d = json_decode($c['Distribution']);

              if ($c['agent'] == 0) {
                $agent = '<span class="text-gray">not needed</span>';
              } else if ($c['agent'] == 1) {
                $agent = '<a data-order="'.$c['Code'].'" class="set_del_agent text-red">not set</a>';
              } else {
                $agent = '<span class="text-green">' . $c['agentData']->Firstname . ' ' . $c['agentData']->Lastname . '</span>';
              }

              echo "<tr class='text-left' id='deposit_{$c['Code']}'>";
                echo '<td>' . $c['Code'] . '</td>';
                echo '<td>' . $c['user']->Firstname . ' ' . $c['user']->Lastname . '</td>';
                echo '<td>' . lookup('payment_method', $c['PaymentMethod']) . '</td>';
                echo '<td>' . $c['ItemCount'] . '</td>';
                echo '<td>' . peso($c['TotalAmount']) . '</td>';
                echo '<td>' . peso($d->company) . '</td>';
                echo '<td>' . $agent . '</td>';
                echo '<td>' . date('y/m/d', strtotime($c['DateOrdered'])) . '</td>';
                echo '<td><a href="javascript:;" onClick="General.viewOrderStatus('.$c['Code'].')">' . lookup('order_status', $c['Status']) . '</a></td>';
                echo '<td>';
                  echo   '<div class="box-tools">
                          <div class="input-group pull-right" style="width: 10px;">
                            <div class="input-group-btn">';
                    if ($c['Status'] <=3) {
                      echo '<button type="button" class="btn btn-xs btn-success" onClick="General.updateOrderStatus('.$c['Code'].', '.$c['Status'].')"><i class="fa fa-pencil"></i> Status</button>';
                    }
                 echo         '<button type="button" class="btn btn-xs btn-info" onClick="General.viewOrderInvoice('.$c['Code'].')"><i class="fa fa-file-text-o"></i> Invoice</button>
                            </div>
                          </div>
                        </div>';
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

<?php view('pages/orders/modals'); ?>

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