<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Support extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($code = false)
    {
        $viewData = array(
            'pageTitle'     => 'Support',
            'pageSubTitle'  => 'Ambilis Support',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $setting = $this->appdb->getRowObject('Settings', 'support', 'key');
        $viewData['content'] = $setting->value ?? '';

        // view('main/misc/misc_page', $viewData, 'templates/main');
        view('main/misc/support', $viewData, 'templates/main');

    }

    public function amcloud()
    {
        $viewData = array(
            'pageTitle'     => 'Ambilis Cloud',
            'pageSubTitle'  => '&nbsp;',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $setting = $this->appdb->getRowObject('Settings', 'ambilis_cloud', 'key');
        $viewData['content'] = $setting->value ?? '';

        view('main/misc/misc_page', $viewData, 'templates/main');
    }

}
