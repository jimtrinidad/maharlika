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
            'pageTitle'         => 'Dashboard',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details()
        );

        $viewData['user_count']    = $this->db->query('SELECT COUNT(*) AS count FROM Users WHERE deletedAt IS NULL')->row()->count;
        $viewData['product_count'] = $this->db->query('SELECT COUNT(*) AS count FROM StoreItems')->row()->count;
        $viewData['store_count']   = $this->db->query('SELECT COUNT(*) AS count FROM StoreDetails')->row()->count;
        $viewData['origin_count']  = $this->db->query('SELECT COUNT(DISTINCT(UPPER(TRIM(Manufacturer)))) AS `count` 
                                                        FROM StoreItems 
                                                        WHERE Manufacturer IS NOT NULL AND Manufacturer != ""')->row()->count;

        $viewData['ecpay_wallet']  = $this->ecpay->ecpay_check_balance();
        $viewData['ecpay_gate']    = $this->ecpay->gate_check_balance();

        $viewData['deposits']      = $this->db->query('SELECT SUM(Amount) AS amount FROM WalletDeposits WHERE Status = 1')->row()->amount;
        $viewData['rewards']       = $this->db->query('SELECT SUM(Amount) AS amount FROM WalletRewards WHERE Type != "discount"')->row()->amount;
        $viewData['debits']        = $this->db->query('SELECT SUM(Amount) as amount FROM WalletTransactions WHERE Type = "Debit"')->row()->amount;
        // print_data($viewData);

        view('pages/dashboard', $viewData, 'templates/main');
    }

}
