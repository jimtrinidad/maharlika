<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Connections extends CI_Controller
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
            'pageTitle'     => 'My Wallet',
            'pageSubTitle'  => 'Ambilis ng Referrals!',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            )
        );

        $transaction = get_transactions(current_user());
        $viewData['transactions'] = $transaction['transactions'];
        $viewData['summary']      = $transaction['summary'];

        $connections = $this->appdb->getRecords('Users', array('Referrer' => current_user()));
        $viewData['total_earnings'] = 0;
        foreach ($connections as &$i) {
            $earnings = $this->db->query('SELECT SUM(Amount) AS total FROM WalletRewards WHERE FromUserID = ' . $i['id'])->row()->total;
            $i['earnings'] = $earnings;
            $viewData['total_earnings'] += $earnings;
        }

        foreach ($connections as &$c) {
            $c['connections'] = $this->appdb->getRecords('Users', array('Referrer' => $c['id']));
        }

        $viewData['connections'] = $connections;

        view('main/connections/index', $viewData, 'templates/main');
    }

}
