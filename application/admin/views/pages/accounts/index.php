<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary small">

      <div class="box-header">
        <h3 class="box-title">Accounts List</h3>
        <div class="box-tools">
          <form action="<?php echo site_url('accounts') ?>" method="get" class="form-inline">
            <div class="form-group">
              <select class="form-control input-sm" id="search_account_status" name="search_account_status">
                <option value="">Account Status</option>
                <?php
                  foreach (lookup('account_status') as $k => $v) {
                    echo "<option ". ($search_account_status == $k ? 'selected="selected"' : '') ." value='{$k}'>{$v}</option>";
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control input-sm" id="search_account_level" name="search_account_level" style="min-width: 150px;">
                <option value="">Account Level</option>
                <?php
                  foreach (lookup('account_level') as $k => $v) {
                    echo "<option ". ($search_account_level == $k ? 'selected="selected"' : '') ." value='{$k}'>{$v}</option>";
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <input type="text" autocomplete="off" id="search_mid" name="search_mid" value="<?php echo $search_mid ?>" class="form-control input-sm" placeholder="Public ID">
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
            <th>ID</th>
            <th>Name</th>
            <th class="hidden-xs hidden-sm">Email</th>
            <th class="hidden-xs">Contact</th>
            <th>Balance</th>
            <th>Referrer</th>
            <th>Level</th>
            <th>Status</th>
            <th class="visible-lg">Regisration Date</th>
            <th class="c"></th>
          </thead>
          <tbody>
            <?php
            foreach ($accounts as $account) {
              echo "<tr class='text-left'>";
                echo '<td>' . $account['PublicID'] . '</td>';
                echo '<td>' . $account['Firstname'] . ' ' . $account['Lastname'] . '</td>';
                echo '<td class="hidden-xs hidden-sm">' . $account['EmailAddress'] . '</td>';
                echo '<td class="hidden-xs">' . $account['Mobile'] . '</td>';
                echo '<td>' . peso($account['Balance']) . '</td>';
                echo '<td>' . ($account['referrer_data'] ? ($account['referrer_data']->Firstname . ' ' . $account['referrer_data']->Lastname) : '') . '</td>';
                echo '<td>' . lookup('account_level', $account['AccountLevel']) . '</td>';
                echo '<td>';
                  echo '<input class="accountStatusToggle" type="checkbox" '. ($account['Status'] == 1 ? 'checked' : '') .' 
                        data-code="' . $account['RegistrationID'] . '"
                        data-toggle="toggle" 
                        data-on="Active" 
                        data-off="Disabled" 
                        data-size="mini" 
                        data-width="70">';
                echo '</td>';
                echo '<td class="visible-lg">' . date('y/m/d', strtotime($account['DateAdded'])) . '</td>';
                echo '<td>
                        <div class="box-tools">
                          <div class="input-group pull-right" style="width: 10px;">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-xs btn-default" title="Update" onClick="Accounts.editAccount('.$account['id'].')"><i class="fa fa-pencil"></i><span class="visible-lg-inline"> Update</span></button>
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

<?php view('pages/accounts/modals.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    Accounts.accountData = <?php echo json_encode($accounts, JSON_HEX_TAG); ?>;
  });
</script>

<style type="text/css">

</style>