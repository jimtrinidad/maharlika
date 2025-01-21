<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary small">

      <div class="box-header">
        <h3 class="box-title">Partner Outlets</h3>
        <div class="box-tools">
          <form action="<?php echo site_url('outlets') ?>" method="get" class="form-inline">
            <div class="form-group">
              <input type="text" autocomplete="off" id="search_address" name="search_address" value="<?php echo $search_address ?>" class="form-control input-sm" placeholder="Address">
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
        <table class="table table-bordered">
          <thead>
            <th>Name</th>
            <th>Address</th>
            <th>Province</th>
            <th>City</th>
            <th class="visible-lg">Barangay</th>
            <th class="c"></th>
          </thead>
          <tbody>
            <?php
            foreach ($records as $i) {
              echo "<tr class='text-left'>";
                echo '<td>' . $i['Name'] . '</td>';
                echo '<td>' . $i['Address'] . '</td>';
                echo '<td>' . $i['provDesc'] . '</td>';
                echo '<td>' . $i['citymunDesc'] . '</td>';
                echo '<td class="visible-lg">' . $i['brgyDesc'] . '</td>';
                echo '<td>
                        <div class="box-tools">
                          <div class="input-group pull-right" style="width: 10px;">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-xs btn-default" title="Update" onClick="General.editOutlet('.$i['id'].')"><i class="fa fa-pencil"></i><span class="visible-lg-inline"> Update</span></button>
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

<?php view('pages/outlets/modals.php'); ?>

<script type="text/javascript">
  $(document).ready(function(){
    General.itemData = <?php echo json_encode($records, JSON_HEX_TAG); ?>;
  });
</script>

<style type="text/css">

</style>