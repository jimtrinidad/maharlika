<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Outlets extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // require login
        check_authentication();
    }

    public function index()
    {
        $viewData = array(
            'pageTitle'         => 'Partner Outlets',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details(),
            'jsModules'         => array(
                'general'
            )
        );

        $page_limit = 50;
        $page_start = (int) $this->uri->segment(3);

        $where = array();
        $order = 'Name';

        // SET SEARCH FILTER
        $filters = array(
            'search_name',
            'search_address',
            // 'search_city',
        );
        foreach ($filters as $filter) {

            $$filter = get_post($filter);

            if ($filter == 'search_name' && $$filter != false) {
                $where['Name LIKE ']  = "%{$search_name}%";
            } else if ($filter == 'search_address' && $$filter != false) {
                $where['Address LIKE ']  = "%{$search_address}%";
            } else if ($filter == 'search_city' && $$filter != false) {
                $where['City']  = $search_city;
            }

            // search params
            $viewData[$filter] = $$filter;

        }

        $paginatationData = $this->appdb->getPartnerOutlets($page_limit, $page_start, $where, $order);

        // prepare account data
        $records = array();
        foreach ($paginatationData['data'] as $item) {
            $item = (array) $item;
            $records[] = $item;
        }

        $paginationConfig = array(
            'base_url'      => base_url('outlets/index'),
            'total_rows'    => $paginatationData['count'],
            'per_page'      => $page_limit,
            'full_tag_open' => '<ul class="pagination pagination-sm no-margin pull-right">'
        );

        // print_data($records, true);
        $viewData['records']    = $records;
        $viewData['pagination'] = paginate($paginationConfig);

        view('pages/outlets/index', $viewData, 'templates/main');

    }

    public function update()
    {

        if (validate('save_partner_outlet') == FALSE) {
            $return_data = array(
                'status'    => false,
                'message'   => 'Some fields have errors.',
                'fields'    => validation_error_array()
            );
        } else {

            $data = $this->appdb->getRowObject('PartnerOutlets', get_post('id'), 'id');

            if ($data != false) {

                $updateData     = array(
                    'id'            => get_post('id'),
                    'Name'          => get_post('Name'),
                    'Address'       => get_post('Address'),
                    'Province'      => get_post('Province'),
                    'City'          => get_post('City'),
                    'Barangay'      => get_post('Barangay'),
                    'LastUpdate'    => date('Y-m-d H:i:s')
                );


                if ($this->appdb->saveData('PartnerOutlets', $updateData)) {
                    $return_data = array(
                        'status'    => true,
                        'message'   => 'Outlet has been updated successfully.'
                    );
                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Outlet update failed. Please try again later.'
                    );
                }

            } else {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'Outlet does not exists.'
                );
            }

        }

        response_json($return_data);

    }

}
