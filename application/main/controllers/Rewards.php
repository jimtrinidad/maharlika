<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rewards extends CI_Controller
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
            'pageTitle'     => 'Rewards',
            'pageSubTitle'  => 'Ambilis ng Rewards',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $transaction = get_transactions(current_user());
        $viewData['transactions'] = $transaction['transactions'];
        $viewData['summary']      = $transaction['summary'];

        $rewards = $this->appdb->getRecords('WalletRewards', array('AccountID' => current_user()), 'id DESC');

        $connections = array();
        foreach ($rewards as &$reward) {
            if ($reward['FromUserID']) {
                if (!isset($connections[$reward['FromUserID']])) {
                    $fromData = $this->appdb->getRowObject('Users', $reward['FromUserID']);
                    $connections[$reward['FromUserID']] = $fromData;
                } else {
                    $fromData = $connections[$reward['FromUserID']];
                }
                $reward['from'] = array(
                    'public_id'     => $fromData->PublicID,
                    'contact'       => $fromData->Mobile,
                    'email'         => $fromData->EmailAddress
                );
            } else {
                $reward['from'] = false;
            }
        }

        $viewData['transactions'] = $rewards;

        view('main/rewards/index', $viewData, 'templates/main');
    }

}
