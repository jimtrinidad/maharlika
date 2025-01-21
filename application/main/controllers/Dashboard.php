<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
            'pageTitle'     => 'Dashboard',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );        

        view('main/dashboard/mobile_menu', $viewData, 'templates/main');
    }

}
