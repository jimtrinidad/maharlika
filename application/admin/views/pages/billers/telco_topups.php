<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
            <div class="box-header">
        <h3 class="box-title">Link Telco Topups</h3>
        <div class="box-tools">
          <form action="<?php echo site_url('billers/telco_topups') ?>" method="get" class="form-inline">
            <div class="form-group">
              <select class="form-control input-sm" id="search_telco" name="search_telco" style="min-width: 150px;">
                <option value=""></option>
                <?php
                  foreach (lookup('telcos') as $k => $v) {
                    echo "<option ". ($search_telco == $k ? 'selected="selected"' : '') ." value='{$k}'>{$v}</option>";
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
      <div class="box-body table-responsive no-padding">
        <table id="tableData" class="table table-hover">
          <thead>
            <tr>
              <th>Telco</th>
              <th>Tag</th>
              <th>Code</th>
              <th>Denomination</th>
              <th>LastUpdate</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($services as $c) {
              echo "<tr class='text-left' id='item_{$c['Code']}'>";
                echo '<td>' . $c['TelcoName'] . '</td>';
                echo '<td>' . $c['TelcoTag'] . '</td>';
                echo '<td>' . $c['ExtTag'] . '</td>';
                echo '<td>' . $c['Denomination'] . '</td>';
                echo '<td>' . date('m/d/y', strtotime($c['LastUpdate'])) . '</td>';
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