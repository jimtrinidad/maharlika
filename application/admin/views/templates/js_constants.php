<script type="text/javascript">

	/**
	* set global variables
	*/

	window.base_url = function(url) {
		url = (typeof(url) == 'undefined' ? '' : url);
		return '<?php echo base_url() ?>' + url;
	}

	window.public_url = function(url) {
		url = (typeof(url) == 'undefined' ? '' : url);
		return '<?php echo public_url() ?>' + url;
	}

	window.emptySelectOption = '<option value="">--</option>';

	var $global = {
		csrfName: '<?php echo $this->security->get_csrf_token_name(); ?>',
		csrfVal: '<?php echo $this->security->get_csrf_hash(); ?>',
	}


</script>