<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


$config['account_status'] = array(
    1 => 'Active',
    2 => 'Disabled',
    // 3 => 'Deleted'
);

$config['account_level'] = array(
    1 => 'Regular',
    2 => 'Admin',
    // 3 => 'Super Admin'
);

$config['commission_type'] = array(
	1 => 'Transaction Fee',
	2 => 'Commission Percent'
);

$config['delivery_methods'] = array(
	3 => 'Not Applicable',
    1 => 'Company Delivery',
    2 => 'Ambilis Delivery',
);

$config['payment_method'] = array(
    1 => 'eWallet'
);

$config['order_status'] = array(
    1 => 'Processing',
    2 => 'For Delivery',
    3 => 'Delivered',
    4 => 'Completed',
    5 => 'Canceled'
);

$config['wallet_rewards_type'] = array(
    'discount'  => 'Discounts',
    'cashback'  => 'Cashback',
    'referrer'  => 'Referrer Points',
    'shared'    => 'Shared Rewards',
    'delivery'  => 'Delivery'
);

// also use on ecpay merch type (exclude purchase)
$config['wallet_reward_transaction_type'] = array(
    1   => 'Purchase',
    2   => 'Bills Payment',
    3   => 'Ticket Payment',
    4   => 'Mobile Loading',
    5   => 'ECash'
);

$config['mobile_service_provider'] = array(
    1 => 'Globe',
    2 => 'Smart',
    3 => 'Touch Mobile',
    4 => 'Sun Cellular',
    5 => 'ABS-CBN Mobile'
);

$config['biller_type'] = array(
    1   => 'Bills',
    2   => 'Ticketing',
    3   => 'Government'
);

$config['telcos'] = array(
    'GLOBE' => 'Globe',
    'SMART' => 'Smart',
    'SUN'   => 'Sun'
);


$config['delivery_agent_status'] = array(
    0 => 'Pending Application',
    1 => 'Active',
    2 => 'Disable'
);

$config['delivery_agent_man_type'] = array(
    1   => 'Manpower Only',
    2   => 'With Motorcycle',
    3   => 'With Car',
    4   => 'With Van',
    5   => 'With Truck'
);


$config['store_status'] = array(
    0 => 'Pending Application',
    1 => 'Active',
    2 => 'Disable'
);


$config['weight_units'] = array(
    1 => 'Grams',
    2 => 'Kilograms'
);

$config['ecpay_wallet_type'] = array(
    1 => 'ECPAY',
    2 => 'GATE',
);

$config['eclink_reloading_status'] = array(
    0 => 'Pending',
    1 => 'Completed',
    2 => 'Expired'
);

$config['deposit_transfer_status'] = array(
    0 => 'Pending',
    1 => 'Verified',
    2 => 'Declined'
);

$config['countries'] = json_decode(file_get_contents(dirname(__FILE__) . '/countrycodes.json'), true);