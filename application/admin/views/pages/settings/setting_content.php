<h4><?php echo $pageTitle; ?></h4>
<form method="post">
	<!-- <div class="form-group"> -->
		<?php
		if (isset($success)) {
			echo '<div class="alert alert-success alert-dismissible show" role="alert">
						  <strong>Success!</strong> '.$success.'
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>';
		} else if (isset($error)) {
			echo '<div class="alert alert-warning alert-dismissible show" role="alert">
						  <strong>Failed!</strong> '.$error.'
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>';
		}
		?>
	<!-- </div> -->
	<div class="form-group">
		<textarea class="form-control" id="setting_content" name="setting_content" rows="20" placeholder="<?php echo $pageTitle; ?>">
			<?php
			echo $setting_content;
			?>
		</textarea>
	</div>
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<input type="submit" class="btn btn-success pull-right" value="Save Changes">
</form>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
    $('#setting_content').summernote({ height: 500});
	});
</script>