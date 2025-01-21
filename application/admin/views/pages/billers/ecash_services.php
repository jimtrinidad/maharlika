<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Link Encash Services</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table id="tableData" class="table table-hover">
          <thead>
            <tr>
              <td style="width: 50px;"></td>
              <th>Name</th>
              <th>ServiceCode</th>
              <th>Description</th>
              <th>FirstField</th>
              <th>SecondField</th>
              <th>Wallet</th>
              <th>LastUpdate</th>
              <th class="c"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($services as $c) {
              echo "<tr class='text-left' id='item_{$c['Code']}'>";
                echo '<td><img class="logo-small" src="'.public_url() . 'assets/logo/' . logo_filename($c['Image']) .'"></td>';
                echo '<td>' . $c['Name'] . '</td>';
                echo '<td>' . $c['Services'] . '</td>';
                echo '<td>' . $c['Description'] . '</td>';
                echo '<td>' . $c['FirstField'] . '</td>';
                echo '<td>' . $c['SecondField'] . '</td>';
                echo '<td>' . lookup('ecpay_wallet_type', $c['WalletType']) . '</td>';
                echo '<td>' . date('m/d/y', strtotime($c['LastUpdate'])) . '</td>';
                echo '<td>';
                  echo   '<div class="box-tools">
                          <div class="input-group pull-right" style="width: 10px;">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-xs btn-info" onClick="General.updateEcashService(\''.$c['Code'].'\')"><i class="fa fa-pencil"></i> Update</button>
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

<?php view('pages/billers/modals.php'); ?>