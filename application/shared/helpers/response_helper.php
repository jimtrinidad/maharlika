<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* output content type json
*/
function response_json($array, $cache = false, $add_token = true)
{
	$ci =& get_instance();

	if ($cache !== false) {
		$ci->output->cache($cache);
	}

	if ($add_token) {
		if (strtolower($_SERVER['REQUEST_METHOD']) != 'get') {
			$array['token'] = $ci->security->get_csrf_hash();
		}
	}
	$ci->output->set_content_type('application/json')->set_output(json_encode($array));
}