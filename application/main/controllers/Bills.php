<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bills extends CI_Controller
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
            'pageTitle'     => 'Bills Payment',
            'pageSubTitle'  => 'AMBILIS TO PAY BILLS',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $page_limit = 100;
        $page_start = (int) $this->uri->segment(3);

        $order = 'BillerTag';
        $where = array(
            'Status'    => 1,
            'Type'      => 1
        );

        // SET SEARCH FILTER
        if (get_post('search')) {
            $where['CONCAT(Name, Description) LIKE ']  = '%' . get_post('search') . '%';
        }

        $paginatationData = $this->appdb->getPaginationData('Billers', $page_limit, $page_start, $where, $order);

        $billers = array();
        foreach ($paginatationData['data'] as $i) {
            $i = (array) $i;
            $i['Image']  = logo_filename($i['Image']);
            $billers[] = $i;
        }

        $paginationConfig = array(
            'base_url'      => base_url('bills/index'),
            'total_rows'    => $paginatationData['count'],
            'per_page'      => $page_limit,
            'full_tag_open' => '<ul class="pagination pagination-sm no-margin">'
        );

        $viewData['billers']   = $billers;
        $viewData['pagination'] = paginate($paginationConfig);

        view('main/bills/index', $viewData, 'templates/main');
    }

    public function ticket()
    {
        $viewData = array(
            'pageTitle'     => 'Ticket Payment',
            'pageSubTitle'  => 'AMBILIS TO PAY TICKETS',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $page_limit = 100;
        $page_start = (int) $this->uri->segment(3);

        $order = 'BillerTag';
        $where = array(
            'Status'    => 1,
            'Type'      => 2
        );

        // SET SEARCH FILTER
        if (get_post('search')) {
            $where['Name LIKE ']  = '%' . get_post('search') . '%';
        }

        $paginatationData = $this->appdb->getPaginationData('Billers', $page_limit, $page_start, $where, $order);

        $billers = array();
        foreach ($paginatationData['data'] as $i) {
            $i = (array) $i;
            $i['Image']  = logo_filename($i['Image']);
            $billers[] = $i;
        }

        $paginationConfig = array(
            'base_url'      => base_url('bills/ticket'),
            'total_rows'    => $paginatationData['count'],
            'per_page'      => $page_limit,
            'full_tag_open' => '<ul class="pagination pagination-sm no-margin">'
        );

        $viewData['billers']   = $billers;
        $viewData['pagination'] = paginate($paginationConfig);

        view('main/bills/index', $viewData, 'templates/main');
    }

    public function government()
    {
        $viewData = array(
            'pageTitle'     => 'Govenrment Payment',
            'pageSubTitle'  => 'AMBILIS TO PAY',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $page_limit = 100;
        $page_start = (int) $this->uri->segment(3);

        $order = 'BillerTag';
        $where = array(
            'Status'    => 1,
            'Type'      => 3
        );

        // SET SEARCH FILTER
        if (get_post('search')) {
            $where['Name LIKE ']  = '%' . get_post('search') . '%';
        }

        $paginatationData = $this->appdb->getPaginationData('Billers', $page_limit, $page_start, $where, $order);

        $billers = array();
        foreach ($paginatationData['data'] as $i) {
            $i = (array) $i;
            $i['Image']  = logo_filename($i['Image']);
            $billers[] = $i;
        }

        $paginationConfig = array(
            'base_url'      => base_url('bills/government'),
            'total_rows'    => $paginatationData['count'],
            'per_page'      => $page_limit,
            'full_tag_open' => '<ul class="pagination pagination-sm no-margin">'
        );

        $viewData['billers']   = $billers;
        $viewData['pagination'] = paginate($paginationConfig);

        view('main/bills/index', $viewData, 'templates/main');
    }


    // show padala option page
    // routed on /padala
    public function padala()
    {
        $viewData = array(
            'pageTitle'     => 'Money Padala',
            'pageSubTitle'  => 'AMBILIS Mag Padala!',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $order = 'Name';
        $where = array(
            'Status'    => 1
        );

        // SET SEARCH FILTER
        if (get_post('search')) {
            $where['CONCAT(Name, " ", Description) LIKE ']  = '%' . get_post('search') . '%';
        }

        $results = $this->appdb->getRecords('EcashServices', $where, $order);

        $items = array();
        foreach ($results as $i) {
            $i = (array) $i;
            $i['Image']  = logo_filename($i['Image']);
            $items[] = $i;
        }

        $viewData['items']   = $items;

        // print_data($viewData, true);

        view('main/bills/ecash_services', $viewData, 'templates/main');
    }

    // show telco loading option page
    // routed on /eload
    public function eload()
    {
        $viewData = array(
            'pageTitle'     => 'Telco eLoading',
            'pageSubTitle'  => 'AMBILIS Mag Load!',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $order = 'TelcoName, TelcoTag, (Denomination * 1)';
        $where = array(
            'Status'    => 1
        );

        $results = $this->appdb->getRecords('TelcoTopUps', $where, $order);

        $items = array();
        foreach ($results as $i) {
            $i = (array) $i;
            $items[$i['TelcoName']][] = $i;
        }

        $viewData['items']   = $items;

        // print_data($viewData, true);

        view('main/bills/telco_topups', $viewData, 'templates/main');
    }
}
