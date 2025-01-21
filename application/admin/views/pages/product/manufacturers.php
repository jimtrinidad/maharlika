<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Manufacturers</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table id="tableData" class="table table-hover">
          <thead>
            <tr>
              <td style="width: 100px;"></td>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($records as $c) {
              echo "<tr class='text-left'>";
                echo '<td class="text-center"><img class="logo-small" src="'.public_url() . 'assets/products/' . product_filename($c['PartnerImage']) .'"></td>';
                echo '<td>' . $c['Name'] . '</td>';
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