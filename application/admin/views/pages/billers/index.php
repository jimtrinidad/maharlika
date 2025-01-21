<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Link Billers</h3>
        <div class="box-tools">
          <form action="<?php echo site_url('billers') ?>" method="get" class="form-inline">
            <div class="form-group">
              <select class="form-control input-sm" id="search_biller_type" name="search_biller_type" style="min-width: 150px;">
                <option value=""></option>
                <?php
                  foreach (lookup('biller_type') as $k => $v) {
                    echo "<option ". ($search_biller_type == $k ? 'selected="selected"' : '') ." value='{$k}'>{$v}</option>";
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <input type="text" autocomplete="off" id="search_name" name="search_name" value="<?php echo $search_name ?>" class="form-control input-sm" placeholder="Name">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-sm btn-success">Search</button>
            </div>
          </form>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table id="tableData" class="table table-hover">
          <thead>
            <tr>
              <td style="width: 50px;"></td>
              <th>Name</th>
              <th>Type</th>
              <th>BillerTag</th>
              <th>Description</th>
              <th>FirstField</th>
              <th>SecondField</th>
              <th>ServiceCharge</th>
              <th>LastUpdate</th>
              <th class="c"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($billers as $c) {
              echo "<tr class='text-left' id='biller_{$c['Code']}'>";
                echo '<td><img class="logo-small" onClick="General.updateBillerLogo(\''. $c['Code'] .'\')" src="'.public_url() . 'assets/logo/' . logo_filename($c['Image']) .'"></td>';
                echo '<td>' . $c['Name'] . '</td>';
                echo '<td data-val="'.$c['Type'].'">' . lookup('biller_type', $c['Type']) . '</td>';
                echo '<td>' . $c['BillerTag'] . '</td>';
                echo '<td>' . $c['Description'] . '</td>';
                echo '<td>' . $c['FirstField'] . '</td>';
                echo '<td>' . $c['SecondField'] . '</td>';
                echo '<td>' . $c['ServiceCharge'] . '</td>';
                echo '<td>' . date('m/d/y', strtotime($c['LastUpdate'])) . '</td>';
                echo '<td>';
                  echo   '<div class="box-tools">
                          <div class="input-group pull-right" style="width: 10px;">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-xs btn-info" onClick="General.updateBillerLogo(\''.$c['Code'].'\')"><i class="fa fa-pencil"></i> Update</button>
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