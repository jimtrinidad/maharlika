<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transactions extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // require login
        check_authentication();
    }

    public function ecpay()
    {
        $viewData = array(
            'pageTitle'         => 'Link Transactions',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details(),
            'jsModules'         => array(
                'general'
            )
        );

        $page_limit = 50;
        $page_start = (int) $this->uri->segment(3);

        $where = array();
        $order = 'TransactionDate DESC';

        // SET SEARCH FILTER
        $filters = array(
            'search_user',
            'search_name',
        );
        foreach ($filters as $filter) {

            $$filter = get_post($filter);

            if ($filter == 'search_user' && $$filter != false) {
                $where['CONCAT(Firstname, " ", Lastname) LIKE ']  = "%{$search_user}%";
            } else if ($filter == 'search_name' && $$filter != false) {
                $where['MerchantName LIKE ']  = "%{$search_name}%";
            }

            // search params
            $viewData[$filter] = $$filter;

        }

        $paginatationData = $this->appdb->getECpayTransactions($page_limit, $page_start, $where, $order);

        // prepare account data
        $items = array();
        foreach ($paginatationData['data'] as $item) {
            $item    = (array) $item;
            $rewards = $this->appdb->getRewardsData(array(
                            'OrderID'       => $item['id'],
                            'TransactType'  => $item['MerchantType']
                        ), 'Type');

            foreach ($rewards as &$reward) {
                $reward['Type']   = lookup('wallet_rewards_type', $reward['Type']);
                $reward['Amount'] = peso($reward['Amount'], true, 4);
            }
            $item['Rewards'] = $rewards;
            $items[] = $item;
        }

        $paginationConfig = array(
            'base_url'      => base_url('transactions/ecpay'),
            'total_rows'    => $paginatationData['count'],
            'per_page'      => $page_limit,
            'full_tag_open' => '<ul class="pagination pagination-sm no-margin pull-right">'
        );

        $viewData['records']    = $items;
        $viewData['pagination'] = paginate($paginationConfig);

        // print_data($viewData, true);

        view('pages/transactions/ecpay', $viewData, 'templates/main');
    }

}
