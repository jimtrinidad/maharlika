<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Stores</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table id="tableData" class="table table-hover table-middle">
          <thead>
            <tr>
              <th>Code</th>
              <th>Owner</th>
              <th>Contact</th>
              <th>Store Name</th>
              <th>Store Contact</th>
              <th>Items</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($records as $c) {
              echo "<tr class='text-left' id='store_{$c['Code']}'>";
                echo '<td>' . $c['Code'] . '</td>';
                echo '<td>' . $c['accountData']->Firstname . ' ' . $c['accountData']->Lastname . '</td>';
                echo '<td>' . $c['accountData']->EmailAddress . '<br>' . $c['accountData']->Mobile . '</td>';
                echo '<td>' . $c['Name'] . '</td>';
                echo '<td>' . $c['Address'] . '<br>' . $c['Email']  . '<br>' . $c['Contact'] . '</td>';
                echo '<td><h3>' . $c['ItemCount'] . '</h3></td>';
                // echo '<td>' . lookup('store_status', $c['Status']) . '</td>';
                echo '<td>';
                  if ($c['Status'] == 0) {
                    echo 'Pending';
                    echo '<br><button type="button" class="btn btn-xs btn-success" onClick="Products.approveStore('.$c['Code'].')"><i class="fa fa-check"></i> Approve</button>';
                  } else {
                    echo '<input class="storeStatusToggle" type="checkbox" '. ($c['Status'] == 1 ? 'checked' : '') .' 
                          data-code="' . $c['Code'] . '"
                          data-toggle="toggle" 
                          data-on="Active" 
                          data-off="Disabled" 
                          data-size="mini" 
                          data-width="70">';
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>