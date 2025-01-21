<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Categories</h3>
        <div class="box-tools">
          <!-- <form action="" method="get">
            <div class="input-group input-group-sm" style="width: 250px;">
              <input type="text" autocomplete="off" id="search" name="search" value="<?php echo get_post('search'); ?>" class="form-control pull-right" placeholder="Search">
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                <button type="button" class="btn btn-success" onClick="Products.addCategory();" title="Add Category"><i class="fa fa-plus"></i> Add</button>
              </div>
            </div>
          </form> -->
          <button type="button" class="btn btn-success" onClick="Products.addCategory();" title="Add Category"><i class="fa fa-plus"></i> Add</button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table id="tableData" class="table table-hover">
          <thead>
            <tr>
              <td style="width: 50px;"></td>
              <th>Code</th>
              <th>Name</th>
              <th>Last Update</th>
              <th class="c"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($categories as $c) {
              echo "<tr class='text-left'>";
                echo '<td><img class="logo-small" src="'.public_url() . 'assets/uploads/' . upload_filename($c['Image']) .'"></td>';
                echo '<td>' . $c['Code'] . '</td>';
                echo '<td>' . $c['Name'] . '</td>';
                echo '<td>' . date('m/d/y H:i', strtotime($c['LastUpdate'])) . '</td>';
                echo '<td>
                        <div class="box-tools">
                          <div class="input-group pull-right" style="width: 10px;">
                            <div class="input-group-btn">' .
                            (
                              count($c['subCategories'])
                              ? '
                                <button type="button" class="btn btn-xs btn-info" onClick="Products.toggleSubCategories('.$c['id'].')"><i class="fa fa-level-down"></i> Sub Categories</button>'
                              : '' 
                            )
                              . '<button type="button" class="btn btn-xs btn-default" title="Add sub category" onClick="Products.addSubCategory('.$c['id'].')"><i class="fa fa-plus"></i> Add</button>
                              <button type="button" class="btn btn-xs btn-default" onClick="Products.editCategory('.$c['id'].')"><i class="fa fa-pencil"></i></button>
                              <button type="button" class="btn btn-xs btn-danger" onClick="Products.deleteCategory('.$c['id'].')"><i class="fa fa-trash"></i></button>
                            </div>
                          </div>
                        </div> 
                      </td>';
              echo '</tr>';
              echo '<tbody id="cat_'.$c['id'].'" class="' . (get_post('searchKeyword') ? '' : 'hidden') . '">';
              foreach ($c['subCategories'] as $sc) {
                echo "<tr class='text-left info small'>";
                  echo '<td class="indent-30"><img class="logo-smaller" src="'.public_url() . 'assets/uploads/' . upload_filename($sc['Image']) .'"></td>';
                  echo '<td class="indent-30">' . $sc['Code'] . '</td>';
                  echo '<td class="indent-30">' . $sc['Name'] . '</td>';
                  echo '<td>' . date('m/d/y H:i', strtotime($sc['LastUpdate'])) . '</td>';
                  echo '<td>
                          <div class="box-tools">
                            <div class="input-group pull-right" style="width: 10px;">
                              <div class="input-group-btn">
                                <button type="button" class="btn btn-xs btn-default" onClick="Products.editSubCategory('.$c['id'].','.$sc['id'].')"><i class="fa fa-pencil"></i> Edit</button>
                                <button type="button" class="btn btn-xs btn-danger" onClick="Products.deleteSubCategory('.$c['id'].','.$sc['id'].')"><i class="fa fa-trash"></i></button>
                              </div>
                            </div>
                          </div> 
                        </td>';
                echo '</tr>';
              }
              echo '</tbody>';
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.6.0/Sortable.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    Products.categoryData = <?php echo json_encode($categories, JSON_HEX_TAG); ?>;
  });
</script>