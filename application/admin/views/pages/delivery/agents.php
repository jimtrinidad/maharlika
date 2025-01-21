<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Delivery Agents</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table id="tableData" class="table table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Contact</th>
              <th>Documents</th>
              <th>ManType</th>
              <th>Status</th>
              <th>DateApplied</th>
              <th class="c"></th> 
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($records as $c) {
            	$docs = json_decode($c['Requirements']);
              echo "<tr class='text-left' id='agent_{$c['Code']}'>";
                echo '<td>' . $c['accountData']->Firstname . ' ' . $c['accountData']->Lastname . '</td>';
                echo '<td>' . $c['accountData']->EmailAddress . '<br>' . $c['accountData']->Mobile . '</td>';
                echo '<td>';
                foreach ($docs as $k => $doc) {
                	echo '<a href="'.public_url('assets/uploads/' . upload_filename($doc)).'" data-toggle="lightbox" data-gallery="example-gallery" data-title="'.ucwords(strtolower(str_replace('_', ' ', $k))).'">
					                <img src="'.public_url('assets/uploads/' . upload_filename($doc)).'" class="img-fluid logo-small">
					            </a>';
                }
                echo '</td>';
                echo '<td>' . lookup('delivery_agent_man_type', ($c['ManType'] ? $c['ManType'] : 0)) . '</td>';
                echo '<td>' . lookup('delivery_agent_status', $c['Status']) . '</td>';
                echo '<td>' . date('m/d/y', strtotime($c['DateApplied'])) . '</td>';
                echo '<td>';
                  echo   '<div class="box-tools">
                          <div class="input-group pull-right" style="width: 10px;">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-xs btn-success" onClick="Delivery.updateAgentStatus('.$c['Code'].')"><i class="fa fa-pencil"></i> Update</button>';
						                 	if ($c['Status'] == 0) {
						                    echo '<button type="button" class="btn btn-xs btn-danger" onClick="Delivery.cancelAgentApplication('.$c['Code'].')"><i class="fa fa-ban"></i> Decline</button>';
						                  }
                  echo     '</div>
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

<?php view('pages/delivery/modals.php'); ?>

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