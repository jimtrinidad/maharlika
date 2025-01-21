<?php
defined('BASEPATH') or exit('No direct script access allowed');

class U extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($id)
    {
        $user = $this->appdb->getRowObject('Users', $id, 'PublicID');
        if ($user) {

            // open registration, set user as referrer
            if (isGuest()) {

                $viewData = array(
                    'pageTitle' => 'Sign up',
                    'RegistrationID' => microsecID(),
                    'jsModules' => array(
                        'account'
                    )
                );

                // view('account/registration', $viewData, 'templates/account');
                $_POST['r'] = $id;
                view('account/registration', $viewData);

            } else {
                // redirect to myaccount
                redirect(site_url('account'));
            }
        } else {
            redirect();
        }
    }

}
