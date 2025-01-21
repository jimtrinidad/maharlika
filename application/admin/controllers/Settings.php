<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // require login
        check_authentication();
    }

    public function terms()
    {
        $viewData = array(
            'pageTitle'         => 'Terms & Conditions',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details()
        );

        $setting = $this->appdb->getRowObject('Settings', 'terms', 'key');

        if (isset($_POST['setting_content'])) {
            $saveData = array(
                'value'         => get_post('setting_content'),
                'last_update'   => datetime()
            );

            if ($setting) {
                $saveData['id'] = $setting->id;
            } else {
                $saveData['key'] = 'terms';
            }
            if ($this->appdb->saveData('Settings', $saveData)) {
                $viewData['success'] = 'Terms & Condition content has been saved!';
                $setting = $this->appdb->getRowObject('Settings', 'terms', 'key');
            } else {
                $viewData['error'] = 'Saving failed.';
            }
        }

        $viewData['setting_content'] = $setting->value ?? '';

        view('pages/settings/setting_content', $viewData, 'templates/main');
    }

    public function how()
    {
        $viewData = array(
            'pageTitle'         => 'How it Works',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details()
        );

        $setting = $this->appdb->getRowObject('Settings', 'howitworks', 'key');

        if (isset($_POST['setting_content'])) {
            $saveData = array(
                'value'         => get_post('setting_content'),
                'last_update'   => datetime()
            );

            if ($setting) {
                $saveData['id'] = $setting->id;
            } else {
                $saveData['key'] = 'howitworks';
            }
            if ($this->appdb->saveData('Settings', $saveData)) {
                $viewData['success'] = 'How it Works content has been saved!';
                $setting = $this->appdb->getRowObject('Settings', 'howitworks', 'key');
            } else {
                $viewData['error'] = 'Saving failed.';
            }
        }

        $viewData['setting_content'] = $setting->value ?? '';

        view('pages/settings/setting_content', $viewData, 'templates/main');
    }

    public function support()
    {
        $viewData = array(
            'pageTitle'         => 'Support',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details()
        );

        $setting = $this->appdb->getRowObject('Settings', 'support', 'key');

        if (isset($_POST['setting_content'])) {
            $saveData = array(
                'value'         => get_post('setting_content'),
                'last_update'   => datetime()
            );

            if ($setting) {
                $saveData['id'] = $setting->id;
            } else {
                $saveData['key'] = 'support';
            }
            if ($this->appdb->saveData('Settings', $saveData)) {
                $viewData['success'] = 'Support content has been saved!';
                $setting = $this->appdb->getRowObject('Settings', 'support', 'key');
            } else {
                $viewData['error'] = 'Saving failed.';
            }
        }

        $viewData['setting_content'] = $setting->value ?? '';

        view('pages/settings/setting_content', $viewData, 'templates/main');
    }


    public function cloud()
    {
        $viewData = array(
            'pageTitle'         => 'Ambilis Cloud',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details()
        );

        $setting = $this->appdb->getRowObject('Settings', 'ambilis_cloud', 'key');

        if (isset($_POST['setting_content'])) {
            $saveData = array(
                'value'         => get_post('setting_content'),
                'last_update'   => datetime()
            );

            if ($setting) {
                $saveData['id'] = $setting->id;
            } else {
                $saveData['key'] = 'ambilis_cloud';
            }
            if ($this->appdb->saveData('Settings', $saveData)) {
                $viewData['success'] = 'Content has been saved!';
                $setting = $this->appdb->getRowObject('Settings', 'ambilis_cloud', 'key');
            } else {
                $viewData['error'] = 'Saving failed.';
            }
        }

        $viewData['setting_content'] = $setting->value ?? '';

        view('pages/settings/setting_content', $viewData, 'templates/main');
    }


    public function fund_wallet_instruction()
    {
        $viewData = array(
            'pageTitle'         => 'Fund Wallet Instructions',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details()
        );

        $setting = $this->appdb->getRowObject('Settings', 'fund_wallet_instruction', 'key');

        if (isset($_POST['setting_content'])) {
            $saveData = array(
                'value'         => get_post('setting_content'),
                'last_update'   => datetime()
            );

            if ($setting) {
                $saveData['id'] = $setting->id;
            } else {
                $saveData['key'] = 'fund_wallet_instruction';
            }
            if ($this->appdb->saveData('Settings', $saveData)) {
                $viewData['success'] = 'Funding wallet instruction content has been saved!';
                $setting = $this->appdb->getRowObject('Settings', 'fund_wallet_instruction', 'key');
            } else {
                $viewData['error'] = 'Saving failed.';
            }
        }

        $viewData['setting_content'] = $setting->value ?? '';

        view('pages/settings/setting_content', $viewData, 'templates/main');
    }

}
