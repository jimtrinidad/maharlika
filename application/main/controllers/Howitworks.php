<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Howitworks extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($code = false)
    {
        $viewData = array(
            'pageTitle'     => 'How it works',
            'pageSubTitle'  => '&nbsp;',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $setting = $this->appdb->getRowObject('Settings', 'howitworks', 'key');
        $viewData['content'] = $setting->value ?? '';

        view('main/misc/misc_page', $viewData, 'templates/main');
        // view('main/misc/how', $viewData, 'templates/main');

    }

}
