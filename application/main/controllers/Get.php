<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function token()
    {
        die($this->security->get_csrf_hash());
    }


    public function barangay()
    {

    	// if (get_post('citymunCode')) {
    		$this->db->where('citymunCode', get_post('citymunCode'));
    	// }

    	$this->db->order_by('brgyDesc', 'ASC');

    	$items = $this->db->get('UtilLocBrgy')->result_array();

    	if (count($items)) {
    		$return_data = array(
    				'status'	=> true,
    				'data'		=> $items
    			);
    	} else {
    		$return_data = array(
    				'status'	=> false,
    				'message'	=> 'No record found.'
    			);
    	}

    	response_json($return_data);

    }

    public function city()
    {

    	// if (get_post('provCode')) {
    		$this->db->where('provCode', get_post('provCode'));
    	// }

    	$this->db->order_by('citymunDesc', 'ASC');

    	$items = $this->db->get('UtilLocCityMun')->result_array();

    	if (count($items)) {
    		$return_data = array(
    				'status'	=> true,
    				'data'		=> $items
    			);
    	} else {
    		$return_data = array(
    				'status'	=> false,
    				'message'	=> 'No record found.'
    			);
    	}

    	response_json($return_data);

    }

    public function provinces()
    {

    	if (get_post('regCode')) {
        $this->db->where('regCode', get_post('regCode'));
      }

      $this->db->order_by('provDesc', 'ASC');

      $items = $this->db->get('UtilLocProvince')->result_array();

      if (count($items)) {
          $return_data = array(
                  'status'    => true,
                  'data'      => $items
              );
      } else {
          $return_data = array(
                  'status'    => false,
                  'message'   => 'No record found.'
              );
      }

      response_json($return_data);

    }

    public function n2w($n = '') {
      if (is_numeric($n)) {
        echo ucwords(number_to_words($n));
      }
    }


    public function delivery_coverage()
    {
      check_authentication();
      $address = $this->appdb->getRecords('DeliveryAgentCoverageAddress', array('UserID' => current_user()), 'Province');
      $items   = array();
      foreach ($address as $i) {
        $i['names'] = lookup_address($i);
        $items[$i['id']] = $i;
      }
      $return_data = array(
        'status'  => true,
        'data'    => $items
      );
      response_json($return_data);
    }

    public function outlets()
    {
      response_json(json_decode(file_get_contents(dirname(APPPATH) . '/shared/config/partneroutlets.json'), true), 1000);
    }

}
