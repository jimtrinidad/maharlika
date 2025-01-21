<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* render view
*/
function view($view, $data = array(), $template = null, $return = false)
{
	$ci =& get_instance();
	if ($template !== null) {
		$content = $ci->load->view($view, $data, true);
		$data['templateContent'] = $content;
		$rendered = $ci->load->view($template, $data, $return);
	} else {
		$rendered = $ci->load->view($view, $data, $return);
	}

	if ($return) {
		return $rendered;
	}
}

/**
* return request input
*/
function get_post($key)
{	
	$ci =& get_instance();
	return $ci->input->get_post($key);
}

function post($key)
{
	$ci =& get_instance();
	return $ci->input->post($key);
}

function get($key)
{
	$ci =& get_instance();
	return $ci->input->get($key);
}

/**
* is ajax request
*/
function is_ajax()
{
	$ci =& get_instance();
    return $ci->input->is_ajax_request();
}

/**
* public url for both front and admin
*/
function public_url($segment = '')
{
	$base_url = base_url();
	$base_url = rtrim(str_replace('/admin', '', $base_url), '/') . '/';
	if ($segment != '') {
		$base_url = $base_url . trim($segment, '/') . '/';
	}
	return $base_url;
}


/**
* run validation
* get rules from config
*/
function validate($rules, $data = null)
{	
	$ci =& get_instance();
		
	// if validation rules key is provided, get from validation config
	if (is_string($rules)) {
    	$rules = $ci->config->item($rules);
    }

    if ($data !== null) {
		// reset validation and set new data to validate
		$ci->form_validation->reset_validation();
		$ci->form_validation->set_data($data);
	}

    if (is_array($rules)) {
		foreach ($rules as $rule) {
			call_user_func_array(array($ci->form_validation, 'set_rules'), $rule);
		}
		return $ci->form_validation->run();
	}

	// invalid rules
	return false;
}

/**
* return validation error in array
*/
function validation_error_array()
{
	$ci =& get_instance();
	return array_map('ucfirst', array_map('strtolower', $ci->form_validation->error_array()));
}


/**
* create pagination links
*/
function paginate($config)
{	
	$ci =& get_instance();
	$ci->load->library('pagination');

	// required config input
	// base_url
	// total_rows
	// per_page

	$default = array(
		'num_links'		=> 2,
		'uri_segment' 	=> 3
	);

	$config['attributes'] 			= array('class' => 'page-link');
	$default['full_tag_open']   = '<ul class="pagination">';
	$default['full_tag_close']  = '</ul>';
	$default['first_link']      = '<< First';
	$default['last_link']       = 'Last >>';
	$default['first_tag_open']  = '<li class="page-item">';
	$default['first_tag_close'] = '</li>';
	$default['prev_link']       = '< Previous';
	$default['prev_tag_open']   = '<li class="page-item prev">';
	$default['prev_tag_close']  = '</li>';
	$default['next_link']       = 'Next >';
	$default['next_tag_open']   = '<li class="page-item">';
	$default['next_tag_close']  = '</li>';
	$default['last_tag_open']   = '<li>';
	$default['last_tag_close']  = '</li>';
	$default['cur_tag_open']    = '<li class="page-item active"><a class="page-link" href="#">';
	$default['cur_tag_close']   = '</a></li>';
	$default['num_tag_open']    = '<li>';
	$default['num_tag_close']   = '</li>';

	$config = array_merge($default, $config);

	if (count($_GET) > 0) {
		$config['suffix'] 	 = '?' . http_build_query($_GET, '', "&");
		$config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
	}

	$ci->pagination->initialize($config);

	return $ci->pagination->create_links();

}



/**
* @param email options
* @param send now or on background
* @param smtp config to use
*
*/
function send_email($emailParams, $background = true, $smtpConfig = 'info')
{
	$ci =& get_instance();

	$ci->load->config('email');
    $config = $ci->config->item('email');

    if (isset($config[$smtpConfig])) {

		$ci->load->library('email', $config[$smtpConfig]);	    
		$ci->email->set_newline("\r\n");

		foreach ($emailParams as $method => $params)
		{
			if (!is_array($params)) {
				$params = (array) $params;
			}
			call_user_func_array(array($ci->email, $method), $params);
		}

		// set config to use on background sending
		$ci->email->configKey = $smtpConfig;

		$ci->email->send(!$background);

		// var_dump($ci->email->print_debugger());
	}
}




/**
* is authenticated?
* if not
* redirect to loggin page
* if ajax return 
*/
function check_authentication()
{
	$ci =& get_instance();
	if (!$ci->authentication->is_loggedin()) {

		// save referrer
		$ci->load->library('user_agent');
	  $referrer = $ci->agent->referrer();
	  if (stripos($referrer, site_url()) !== false) {
	   		$ci->session->set_userdata('referrer', $referrer);
	  }

    if (!$ci->input->is_ajax_request()) {
		   redirect('account/signin');
		} else {
			header("HTTP/1.1 401 Unauthorized");
			header('Content-Type: application/json');
			echo json_encode(array(
				'status'	=> false,
				'message'	=> 'Unauthorized access.'
			));
			exit;
		}
  }
}

/**
* authtentication is_loggedin shortcut
*/
function isGuest()
{
	$ci =& get_instance();
	if (!$ci->authentication->is_loggedin()) {
		return true;
	} else {
		return false;
	}
}


function photo_filename($filename, $recache = true)
{
	// replace by default avatar if not exists
	$filepath = PUBLIC_DIRECTORY . 'assets/profile/' . $filename;
	return (!empty($filename) && file_exists($filepath) ? $filename . '?' . ($recache ? filemtime($filepath) : '') : 'default.jpg');
}

function logo_filename($filename, $recache = true)
{
	// replace by default logo if not exists
	// recache using last file change
	$filepath = PUBLIC_DIRECTORY . 'assets/logo/' . $filename;
	return (!empty($filename) && file_exists($filepath) ? $filename . '?' . ($recache ? filemtime($filepath) : '')  : 'default.png');
}

function upload_filename($filename, $recache = true)
{
	$filepath = PUBLIC_DIRECTORY . 'assets/uploads/' . $filename;
	return (!empty($filename) && file_exists($filepath) ? $filename . '?' . ($recache ? filemtime($filepath) : '')  : 'default.png');
}

function product_filename($filename, $recache = true)
{
	$filepath = PUBLIC_DIRECTORY . 'assets/products/' . $filename;
	return (!empty($filename) && file_exists($filepath) ? $filename . '?' . ($recache ? filemtime($filepath) : '')  : 'default.png');
}


/**
* current user
*/
function current_user($view = 'id')
{
	$ci =& get_instance();
	$id = $ci->session->userdata('identifier');

	if ($view == 'full') {
		return user_account_details($id);
	} else if ($view == 'name') {
		$data = user_account_details($id);
		return user_full_name($data, 0);
	}

	return $id;
}

/**
* get user raw data
*/
function get_user($userID)
{
	$ci =& get_instance();
	$user = $ci->appdb->getRowObject('UserAccountInformation', $userID, 'id');
	if ($user) {
		return $user;
	}

	return false;
}


function user_account_details($id = false, $connections = true)
{
	$ci =& get_instance();

	if ($id === false) {
		$id = $ci->session->userdata('identifier');
	}

	$user = lookup_row('Users', $id);

	if ($user) {
		$user->fullname = user_full_name($user, 0);

		$user->agent = lookup_row('DeliveryAgents', $user->id, 'UserID');

		if ($user->agent) {
			// check if theres a new order to notify agent
			$user->new_delivery_order = get_new_delivery_order($user->id);
		}

		$store = $ci->appdb->getRowObjectWhere('StoreDetails', array('OwnerID' => $user->id, 'Status' => 1));

		$user->StoreID = false;
		if ($store) {
			$user->StoreID = $store->Slug;
		}

		// connections
		if ($connections) {
			$user->connections = straight_connections(get_user_connections($user->id));
		}

	}


	return $user;

}



/**
* generate full name
* return string
*/
function user_full_name($data, $m = 1)
{	
	$data = (array) $data;
	$middle = ' '; // default
	if (!empty($data['Middlename'])) {
		if ($m == 1) {
			$middle = ' ' . $data['Middlename'] . ' ';
		} else if ($m == 2) {
			$middle = ' ' . substr($data['Middlename'], 0, 1) . ' ';
		}
	}
	return ucwords($data['Firstname'] . $middle . $data['Lastname']);
}

// check if user have deposited atleast one
function have_deposit($userID = false)
{
	if (!$userID) {
		$userID = current_user();
	}

	$ci =& get_instance();

	$sql = "SELECT COUNT(*) as count
					FROM WalletDeposits
					WHERE AccountID = {$userID}
					AND Amount > 0
					AND Status = 1";

    $row = $ci->db->query($sql)->row();
    if ($row && $row->count > 0) {
    	return true;
    } else {
    	return false;
    }
}

// wallet latest balance
function get_latest_wallet_balance($userID = false)
{
	if (!$userID) {
		$userID = current_user();
	}

	$ci =& get_instance();

	$sql = "SELECT EndingBalance
            FROM WalletTransactions
            WHERE AccountID = {$userID}
            ORDER BY id DESC
            LIMIT 1";

    $latest = $ci->db->query($sql)->row();
    if ($latest) {
    	return $latest->EndingBalance;
    } else {
    	return 0;
    }
}


function get_transactions($userID, $limit = 50)
{	
	if (!$userID) {
		$userID = current_user();
	}

	$ci =& get_instance();

	$transactions = $ci->appdb->getRecords('WalletTransactions', array('AccountID' => current_user()), 'id DESC');
  $summary      = array(
    'balance'   => 0,
    'debit'     => 0,
    'credit'    => 0,
    'transactions'  => 0
  );

  foreach ($transactions as &$i) {
    if ($i['Type'] == 'Credit') {
      $i['credit'] = $i['Amount'];
      $i['debit']  = false;
      $summary['credit'] += $i['Amount'];
      $summary['balance'] += $i['Amount'];
      $summary['transactions']++;
    } else {
      $i['debit']  = $i['Amount'];
      $i['credit'] = false;
      $summary['debit'] += $i['Amount'];
      $summary['balance'] -= $i['Amount'];
      $summary['transactions']++;
    }
  }

  $data['transactions'] = $transactions;
  $data['summary']      = $summary;

  return array(
  	'transactions'	=> array_slice($transactions, 0, $limit),
  	'summary'				=> $summary
  );
}

/**
* get downline
*/
function get_user_connections($userID, $level = 0, $max_level = 8)
{
	$ci =& get_instance();
	$connections = array();
	$referrer 		  = $ci->appdb->getRowObject('Users', $userID);
	$referred_users = $ci->appdb->getRecords('Users', array('Referrer' => $userID));
	// print_r($referred_users);

	if ($level < $max_level) {
		$level++;
	}

	foreach ($referred_users as $referred_user) {
		$connections[] = array(
				'referrerID'		=> $referred_user['Referrer'],
				'referrerName'	=> $referrer->Firstname . ' ' . $referrer->Lastname,
				'publicID'		=> $referred_user['PublicID'],
				'id'					=> $referred_user['id'],
				'name'				=> $referred_user['Firstname'] . ' ' . $referred_user['Lastname'],
				'photo'				=> $referred_user['Photo'],
				'connections'	=> get_user_connections($referred_user['id'], $level, $max_level)
		);
		// $connections   = array_merge($connections, get_user_connections($referred_user['id']));
	}

	return array(
		'level'				=> $level,
		'connections'	=> $connections
	);
}

function straight_connections($connection_layer)
{
	$connections = array();
	foreach ($connection_layer['connections'] as $i) {
		$i_con = $i['connections'];
		unset($i['connections']);
		$i['level']	= $connection_layer['level'];
		$connections[] = $i;
		$connections = array_merge($connections, straight_connections($i_con));
	}

	usort($connections, function($a, $b){
		return $a['level'] > $b['level'];
	});
	return $connections;
}

/**
* get upline referrer
*/
function get_upper_referrers($userID, $levels = 8)
{

	$ci =& get_instance();
	$user = $ci->appdb->getRowObject('Users', $userID);
	$partakers = array(
		$userID
	);
	$x 	 	= 1;
	while ($x < $levels) {
		if ($user && $user->Referrer) {
			$user = $ci->appdb->getRowObject('Users', $user->Referrer);
			if ($user) {
				$partakers[] = $user->id;
			} else {
				// no more upper level, stop loop
				break;
			}
		} else {
			break;
		}
		$x++;
	}

	return array_slice($partakers, 0, $levels);
}


function ecpay_save_transaction($data)
{

	$ci =& get_instance();

	$deducted 		= $data['prev_bal'] - $data['new_bal'];
	$commission		= ($data['amount'] + ((int) $data['fee']))	- $deducted;
	$distribution	= ec_profit_distribution($commission);

	$transactionData = array(
		'Code'				=> $data['code'],
		'MerchantType'		=> $data['merch_type'],
		'MerchantID'		=> $data['merch_id'],
		'MerchantName'		=> $data['merch_name'],
		'Amount'			=> $data['amount'],
		'ServiceCharge'		=> $data['fee'],
		'Commission'		=> ($commission > 0 ? $commission : 0),
		'NetAmount'			=> $deducted,
		'UserID'			=> $data['user'],
		'ReferenceNo'		=> $data['refno'],
		'TransactionDate'	=> $data['trans_date'],
		'ECRequestData'		=> json_encode($data['ecrequest']),
		'ECResponseData'	=> json_encode($data['ecresponse']),
		'InvoiceData'		=> json_encode($data['invoice']),
		'RewardDistribution'=> json_encode($distribution),
		'RawData'			=> json_encode($data)
	);

	if (($ID = $ci->appdb->saveData('ECPayTransactions', $transactionData))) {
		if ($commission > 0) {
			distribute_transaction_rewards($transactionData, $ID);
			return $ID;
		}
		return true;
	} else {
		logger('Saving ecpay transaction failed.');
		return false;
	}

}

/**
* distribute ecpay transaction rewards
*/
function distribute_transaction_rewards($data, $transid)
{   

		$ci =& get_instance();

    $has_error = false;

    // user rewards (cashback, 1/8 shared)
    // direct referrer reward (referral points, 1/8 shared)
    // 6 upline of direct referrer (1/8 shared each)
    
    $user = $data['UserID'];
    $distribution = json_decode($data['RewardDistribution']);
    $buyerInfo = $ci->appdb->getRowObject('Users', $user);

    // BUYER
    $rewards = array(
        array(
            'reward_type'   => 'cashback',
            'account_id'    => $user,
            'order_id'      => $transid,
            'from_user'     => null,
            'amount'        => $distribution->cashback,
            'trans_desc'    => 'Cashback from - ' . lookup('wallet_reward_transaction_type', $data['MerchantType']) . ' #' . $data['Code'],
        ),
        array(
            'reward_type'   => 'shared',
            'account_id'    => $user,
            'order_id'      => $transid,
            'from_user'     => null,
            'amount'        => $distribution->divided_reward,
            'trans_desc'    => 'Shared reward from - ' . lookup('wallet_reward_transaction_type', $data['MerchantType']) . ' #' . $data['Code'],
        )

    );

    // REFERRER
    if ($buyerInfo->Referrer) {
        $referrerData = $ci->appdb->getRowObject('Users', $buyerInfo->Referrer);
        if ($referrerData) {
            $rewards[] = array(
                'reward_type'   => 'referrer',
                'account_id'    => $buyerInfo->Referrer,
                'from_user'     => $user,
                'order_id'      => $transid,
                'amount'        => $distribution->referral,
                'trans_desc'    => 'Referral points from ' . lookup('wallet_reward_transaction_type', $data['MerchantType']) . ' #' . $data['Code'] . ' by ' . strtoupper($buyerInfo->Firstname . ' ' . $buyerInfo->Lastname),
            );
            $rewards[] = array(
                'reward_type'   => 'shared',
                'account_id'    => $buyerInfo->Referrer,
                'from_user'     => $user,
                'order_id'      => $transid,
                'amount'        => $distribution->divided_reward,
                'trans_desc'    => 'Shared reward from ' . lookup('wallet_reward_transaction_type', $data['MerchantType']) . ' #' . $data['Code'] . ' by ' . strtoupper($buyerInfo->Firstname . ' ' . $buyerInfo->Lastname),
            );

            // UPPER REFFERS
            $upper_referrers = get_upper_referrers($user);
            foreach ($upper_referrers as $user_id) {
                if (!in_array($user_id, array($user, $buyerInfo->Referrer))) {
                    $rewards[] = array(
                        'reward_type'   => 'shared',
                        'account_id'    => $user_id,
                        'order_id'      => $transid,
                        'from_user'     => $user,
                        'amount'        => $distribution->divided_reward,
                        'trans_desc'    => 'Shared reward from #' . lookup('wallet_reward_transaction_type', $data['MerchantType']) . ' #' . $data['Code'] . ' by ' . strtoupper($buyerInfo->Firstname . ' ' . $buyerInfo->Lastname),
                    );
                }
            }
        }
    }

    foreach ($rewards as $reward) {

        $reward_type = $reward['reward_type'];
        $rewardData = array(
            'Code'        => microsecID(true),
            'AccountID'   => $reward['account_id'],
            'FromUserID'  => $reward['from_user'],
            'OrderID'     => $reward['order_id'],
            'Type'        => $reward_type,
            'Amount'      => $reward['amount'],
            'Description' => $reward['trans_desc'],
            'TransactType'=> $data['MerchantType'],
            'DateAdded'   => datetime()
        );

        if ($ci->appdb->saveData('WalletRewards', $rewardData)) {


                $balance = get_latest_wallet_balance($reward['account_id']);

                $transactions_data = array(
                    'Code'          => microsecID(true),
                    'AccountID'     => $reward['account_id'],
                    'ReferenceNo'   => $rewardData['Code'],
                    'Description'   => $reward['trans_desc'],
                    'Date'          => datetime(),
                    'Amount'        => $reward['amount'],
                    'Type'          => 'Credit',
                    'EndingBalance' => ($balance + $reward['amount'])
                );

                if (!$ci->appdb->saveData('WalletTransactions', $transactions_data)) {
                    $has_error = true;
                    logger('Saving ' . $reward_type . ' reward transaction failed.');
                }

        } else {
            $has_error = true;
            logger('Saving ' . $reward_type . ' reward failed.');
        }

        if ($has_error) {
            break;
        }

    }

    return !$has_error;
}

function get_rewards($where = array(), $order = false)
{
	$ci =& get_instance();
	$rewards = $ci->appdb->getRewardsData($where, $order);

  foreach ($rewards as &$reward) {
      $reward['Type']   = lookup('wallet_rewards_type', $reward['Type']);
      $reward['Amount'] = peso($reward['Amount'], true, 4);
  }

  return $rewards;
}


/**
* distribute order transaction reward
*/
function distribute_order_rewards($order_id)
{   
		$ci =& get_instance();
    $has_error = false;
    $orderData = $ci->appdb->getRowObject('Orders', $order_id);
    if ($orderData) {

        // buyer rewards (cashback, 1/8 shared), log discounts on transactions and rewards but not credited on wallet
        // direct referrer reward (referral points, 1/8 shared)
        // 6 upline of direct referrer (1/8 shared each)

        $buyerInfo = $ci->appdb->getRowObject('Users', $orderData->OrderBy);

        $distribution = json_decode($orderData->Distribution);

        // BUYER
        $rewards = array(
            array(
                'reward_type'   => 'discount',
                'account_id'    => $orderData->OrderBy,
                'order_id'      => $orderData->id,
                'from_user'     => null,
                'amount'        => $distribution->discount,
                'trans_desc'    => 'Discounted from order - Order #' . $orderData->Code,
            ),
            array(
                'reward_type'   => 'cashback',
                'account_id'    => $orderData->OrderBy,
                'order_id'      => $orderData->id,
                'from_user'     => null,
                'amount'        => $distribution->cashback,
                'trans_desc'    => 'Cashback from order - Order #' . $orderData->Code,
            ),
            array(
                'reward_type'   => 'shared',
                'account_id'    => $orderData->OrderBy,
                'order_id'      => $orderData->id,
                'from_user'     => null,
                'amount'        => $distribution->divided_reward,
                'trans_desc'    => 'Shared reward from order - Order #' . $orderData->Code,
            )

        );

        // REFERRER
        if ($buyerInfo->Referrer) {
            $referrerData = $ci->appdb->getRowObject('Users', $buyerInfo->Referrer);
            if ($referrerData) {
                $rewards[] = array(
                    'reward_type'   => 'referrer',
                    'account_id'    => $buyerInfo->Referrer,
                    'from_user'     => $orderData->OrderBy,
                    'order_id'      => $orderData->id,
                    'amount'        => $distribution->referral,
                    'trans_desc'    => 'Referral points from Order #' . $orderData->Code . ' by ' . strtoupper($buyerInfo->Firstname . ' ' . $buyerInfo->Lastname),
                );
                $rewards[] = array(
                    'reward_type'   => 'shared',
                    'account_id'    => $buyerInfo->Referrer,
                    'from_user'     => $orderData->OrderBy,
                    'order_id'      => $orderData->id,
                    'amount'        => $distribution->divided_reward,
                    'trans_desc'    => 'Shared reward from Order #' . $orderData->Code . ' by ' . strtoupper($buyerInfo->Firstname . ' ' . $buyerInfo->Lastname),
                );

                // UPPER REFFERS
                $upper_referrers = get_upper_referrers($orderData->OrderBy);
                foreach ($upper_referrers as $user_id) {
                    if (!in_array($user_id, array($orderData->OrderBy, $buyerInfo->Referrer))) {
                        $rewards[] = array(
                            'reward_type'   => 'shared',
                            'account_id'    => $user_id,
                            'order_id'      => $orderData->id,
                            'from_user'     => $orderData->OrderBy,
                            'amount'        => $distribution->divided_reward,
                            'trans_desc'    => 'Shared reward from Order #' . $orderData->Code . ' by ' . strtoupper($buyerInfo->Firstname . ' ' . $buyerInfo->Lastname),
                        );
                    }
                }
            }
        }

        // DELIVERY AGENT
        if ($orderData->DeliveryMethod == 2 && $orderData->DeliveryAgent) {
        	$rewards[] = array(
                    'reward_type'   => 'delivery',
                    'account_id'    => $orderData->DeliveryAgent,
                    'from_user'     => $orderData->OrderBy,
                    'order_id'      => $orderData->id,
                    'amount'        => $distribution->delivery,
                    'trans_desc'    => 'Delivery payment from Order #' . $orderData->Code . ' of ' . strtoupper($buyerInfo->Firstname . ' ' . $buyerInfo->Lastname),
                );
        }

        foreach ($rewards as $data) {

            $reward_type = $data['reward_type'];
            $rewardData = array(
                'Code'        => microsecID(true),
                'AccountID'   => $data['account_id'],
                'FromUserID'  => $data['from_user'],
                'OrderID'     => $data['order_id'],
                'Type'        => $reward_type,
                'Amount'      => $data['amount'],
                'Description' => $data['trans_desc'],
                'DateAdded'   => datetime()
            );
            if ($ci->appdb->saveData('WalletRewards', $rewardData)) {

                // if discount type. no changes on wallet, just record the on reward logs
                if ($reward_type != 'discount') {
                    $balance = get_latest_wallet_balance($data['account_id']);

                    $transactions_data = array(
                        'Code'          => microsecID(true),
                        'AccountID'     => $data['account_id'],
                        'ReferenceNo'   => $rewardData['Code'],
                        'Description'   => $data['trans_desc'],
                        'Date'          => datetime(),
                        'Amount'        => $data['amount'],
                        'Type'          => 'Credit',
                        'EndingBalance' => ($balance + $data['amount'])
                    );

                    if (!$ci->appdb->saveData('WalletTransactions', $transactions_data)) {
                        $has_error = true;
                        logger('Saving ' . $reward_type . ' reward transaction failed.');
                    }
                }
            } else {
                $has_error = true;
                logger('Saving ' . $reward_type . ' reward failed.');
            }

            if ($has_error) {
                break;
            }

        }


    } else{
        $has_error = true;
        logger('Order data not found.');
    }

    return !$has_error;
}

/**
* return order payment
*/
function refund_order($order_id)
{
	$ci =& get_instance();
  $has_error = false;
  $orderData = $ci->appdb->getRowObject('Orders', $order_id);
  if ($orderData) {
  	
  	$amount  = $orderData->TotalAmount;
  	$balance = get_latest_wallet_balance($orderData->OrderBy);

  	$refno   = 'CC'.$orderData->Code;
  	$transct = $ci->appdb->getRowObject('WalletTransactions', $refno, 'ReferenceNo');

  	if (!$transct) {
	  	$transactions_data = array(
	        'Code'          => microsecID(true),
	        'AccountID'     => $orderData->OrderBy,
	        'ReferenceNo'   => $refno,
	        'Description'   => 'Canceled order refund. Order#' . $orderData->Code,
	        'Date'          => datetime(),
	        'Amount'        => $amount,
	        'Type'          => 'Credit',
	        'EndingBalance' => ($balance + $amount)
	    );

	    if ($ci->appdb->saveData('WalletTransactions', $transactions_data)) {
	        return true;
	        logger($orderData->Code . ' order payment refunded.');
	    } else {
	    	logger($orderData->Code . ' order refund failed.');
	    }
	  } else {
	  	logger($orderData->Code . ' order was already refunded.');
	  }
  }

  return false;
}


function record_order_status($order_id, $status, $remarks = false, $image = false)
{

	$ci =& get_instance();

	$saveData = array(
		'OrderID'	 => $order_id,
		'Status'	 => $status,
		'Datetime'   => datetime(),
		'UpdatedBy'	 => current_user()
	);

	if ($remarks) {
		$saveData['Remarks'] = $remarks;
	}

	if ($image) {
		$saveData['Image'] = $image;
	}

	return $ci->appdb->saveData('OrderStatus', $saveData);

}


// get stores id on user location
function get_near_stores($user)
{
	$ci =& get_instance();

	$store_ids = array();

	$sql = "SELECT id FROM StoreDetails
					WHERE City IN (
						SELECT City FROM UserAddress WHERE UserID = {$user}
					)";

	$results = $ci->db->query($sql)->result_array();
	foreach ($results as $r) {
		$store_ids[] = $r['id'];
	}

	$sql = "SELECT StoreID FROM StoreLocations
					WHERE City IN (
						SELECT City FROM UserAddress WHERE UserID = {$user}
					)";

	$results = $ci->db->query($sql)->result_array();
	foreach ($results as $r) {
		$store_ids[] = $r['StoreID'];
	}

	$store_ids = array_unique($store_ids);
	if (count($store_ids)) {
		return $store_ids;
	}
	return false;
}


function find_delivery_agent($address)
{

	// find all agents in the area
	$ci =& get_instance();
	$sql = "SELECT a.UserID
			FROM DeliveryAgentCoverageAddress  a
            JOIN DeliveryAgents s ON s.UserID = a.UserID
			WHERE s.Status = 1
				AND (
					Barangay = ?
					OR (Barangay = '' AND City = ?)
				)";
	$results = $ci->db->query($sql, array($address->Barangay, $address->City))->result_array();

	$userids = array();
	foreach ($results as $r) {
		if (current_user() != $r['UserID']) {
			$userids[] = $r['UserID'];
		}
	}

	if (count($userids)) {
		// all agent with no/lowest active order and lowest completed order
		$sql = "SELECT DeliveryAgent, SUM(IF(Status <= 3, 1, 0)) AS Active, SUM(IF(Status = 4, 1, 0)) AS Completed 
				FROM Orders
				WHERE DeliveryAgent IS NOT NULL
					AND DeliveryAgent IN (".implode(',', $userids).")
				GROUP BY DeliveryAgent
				ORDER BY Active, Completed";

		$items  = $ci->db->query($sql)->result_array();
		$found	= array();

		foreach ($items as $r) {
			$found[] = $r['DeliveryAgent'];
		}

		// return agent that doesnt have any previous record
		foreach ($userids as $user) {
			if (!in_array($user, $found)) {
				return $user;
			}
		}

		// return first found result, already sorted by query
		if (isset($found[0])) {
			return $found[0];
		}

	}
	
	return false;

}


function get_new_delivery_order($user)
{
	$ci =& get_instance();
	$sql = 'SELECT *
			FROM Orders
			WHERE DeliveryMethod = ?
				AND DeliveryAgent = ?
				AND NotifiedAgent = ?
				AND Status < ?
			ORDER BY id DESC';

	$results = $ci->db->query($sql, array(2, $user, 0, 3))->result_array();

	$records = array();
	foreach ($results as $r) {
		$user    		= $ci->appdb->getRowObject('Users', $r['OrderBy']);
		$addressData    = $ci->appdb->getRowObject('UserAddress', $r['AddressID']);

		$addressData->names = lookup_address($addressData);

		$records[] = (object) array(
			'order_id'	 => $r['id'],
			'order_code' => $r['Code'],
			'order_date' => $r['DateOrdered'],
			'name'		 => $user->Firstname . ' ' . $user->Lastname,
			'photo'		 => photo_filename($user->Photo),
			'email'      => $user->EmailAddress,
            'mobile'     => ($user->DialCode ? '+' . $user->DialCode : '') . $user->Mobile,
            'user_id'    => $user->PublicID,
            'address'	 => ucwords(strtolower($addressData->Street . ', Barangay ' . $addressData->names['Barangay'] . ', ' . $addressData->names['MuniCity'] . ', ' . $addressData->names['Province']))
		);
	}

	return $records;

}