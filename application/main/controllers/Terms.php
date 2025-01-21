<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Terms extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($code = false)
    {
        $viewData = array(
            'pageTitle'     => 'Terms & Conditions',
            'pageSubTitle'  => 'Ambilis Terms & Conditions',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $setting = $this->appdb->getRowObject('Settings', 'terms', 'key');
        $viewData['content'] = $setting->value ?? '';

        view('main/misc/misc_page', $viewData, 'templates/main');

    }

}
