<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
* account registration form
*/

$config['account_registration'] = array(

	array('Firstname', 'First name', 'trim|required|regex_match[/^[a-zA-Z ]+$/]',
		array(
	        'regex_match' => '%s has invalid characters. Letters and space only.'
	    )),
	array('Lastname', 'Last name', 'trim|required|regex_match[/^[a-zA-Z. ]+$/]',
		array(
	        'regex_match' => '%s has invalid characters. Letters and space only.'
	    )),
	array('EmailAddress', 'Email address', 'trim|required|valid_email|min_length[5]|is_unique[Users.EmailAddress]',
	    array(
	        'is_unique' => 'Email address already exists.'
	    )),
	array('Mobile', 'Mobile number', 'trim|required|is_unique[Users.Mobile]',
		array(
	        'is_unique' => 'Mobile number already exists.'
	    )),
	array('Password', 'Password', 'required|min_length[8]|max_length[16]'),
	array('ConfirmPassword', 'Password confirmation', 'required|matches[Password]'),
	array('Referrer', 'Referrer', 'trim|required')
);


$config['account_update'] = array(

	array('account_firstname', 'First name', 'trim|required|regex_match[/^[a-zA-Z ]+$/]',
		array(
	        'regex_match' => '%s has invalid characters. Letters and space only.'
	    )),
	array('account_lastname', 'Last name', 'trim|required|regex_match[/^[a-zA-Z. ]+$/]',
		array(
	        'regex_match' => '%s has invalid characters. Letters and space only.'
	    )),
	array('account_email', 'Email address', 'trim|required|valid_email|min_length[5]|callback_unique_account_email',
	    array(
	        'unique_account_email' => 'Email address already exists.'
	    )),
	array('account_mobile', 'Mobile number', 'trim|required|callback_unique_account_mobile',
		array(
	        'unique_account_mobile' => 'Mobile number already exists.'
	    ))
);

$config['forgot_password'] = array(
	array('account_email', 'Email address', 'trim|required|valid_email|min_length[5]')
);

$config['reset_password'] = array(
	array('reset_code', 'Reset code', 'trim|required'),
	array('Password', 'Password', 'required|min_length[8]|max_length[16]'),
	array('ConfirmPassword', 'Password confirmation', 'required|matches[Password]')
);

$config['user_address'] = array(
	array('AddressProvince', 'Province', 'trim|required'),
	array('AddressCity', 'City/Municipal', 'trim|required'),
	array('AddressBarangay', 'Barangay', 'trim|required'),
	array('AddressStreet', 'Home number & street', 'trim|required'),
);


$config['verify_delivery_agent'] = array(
	array('agent_status', 'Status', 'trim|required'),
	array('agent_man_type', 'Type', 'trim|required'),
);

$config['delivery_coverage_address'] = array(
	array('DAAddressProvince', 'Province', 'trim|required'),
	array('DAAddressCity', 'City/Municipal', 'trim|required'),
);

$config['save_store_profile'] = array(
	array('Name', 'Store name', 'trim|required'),
	array('SDProvince', 'Province', 'trim|required'),
	array('SDCity', 'City/Municipal', 'trim|required'),
	array('SDBarangay', 'Barangay', 'trim|required'),
	array('Address', 'Street', 'trim|required'),
	array('MinimumOrder', 'Minimum order amount', 'trim|required|numeric|greater_than_equal_to[0]'),
);

$config['store_address'] = array(
	array('SAddressProvince', 'Province', 'trim|required'),
	array('SAddressCity', 'City/Municipal', 'trim|required'),
	array('SAddressBarangay', 'Barangay', 'trim|required'),
	// array('SAddressStreet', 'Street', 'trim|required'),
);

$config['save_store_item'] = array(
	array('Name', 'Product name', 'trim|required'),
	array('Description', 'Product description', 'trim'),
	array('Price', 'Price', 'trim|required|numeric'),
	array('CommissionType', 'Commission type', 'trim|required|numeric'),
	array('CommissionValue', 'Commission value', 'trim|required|numeric'),
	array('MinimumQuantity', 'Minimum Quantity', 'trim|numeric'),
	array('Stock', 'Stock', 'trim|numeric'),
);


$config['add_deposit'] = array(
	array('Bank', 'Payment partner', 'trim|required'),
	array('Branch', 'Location', 'trim|required'),
	array('ReferenceNo', 'Transaction number', 'trim|required'),
	array('Date', 'Transaction date', 'trim|required'),
	array('Amount', 'Fund amount', 'trim|required|numeric|greater_than[0]')
);

$config['commit_eclink_payment'] = array(
	array('Amount', 'Amount', 'trim|required|numeric|greater_than[0]'),
	array('Remarks', 'Remarks', 'trim|max_length[50]'),
);

$config['encash_request'] = array(
	array('Amount', 'Amount', 'trim|required|numeric'),
);

$config['money_padala_request'] = array(
	array('ServiceType', 'Service Type', 'trim|required'),
	array('AccountNo', 'Account Number', 'trim|required'),
	array('Identifier', 'Identifier', 'trim|required'),
	array('Amount', 'Amount', 'trim|required|numeric'),
);

$config['add_payment'] = array(
	array('Biller', 'Biller', 'trim|required'),
	array('AccountNo', 'Account Number', 'trim|required'),
	array('Identifier', 'Identifier', 'trim|required'),
	array('Amount', 'Amount', 'trim|required|numeric'),
);

$config['send_eload'] = array(
	array('LoadTag', 'Load Type', 'trim|required'),
	array('Number', 'Mobile number', 'trim|required|numeric|min_length[11]|max_length[11]'),
	// array('Amount', 'Load amount', 'trim|required|numeric'),
);


// ADMIN 

$config['save_product_category'] = array(
	array('Name', 'Category name', 'trim|required'),
);

$config['save_product_sub_category'] = array(
	array('Name', 'Sub category name', 'trim|required'),
	array('CategoryID', 'Parent category', 'required'),
);

$config['save_partner_outlet'] = array(
	array('Name', 'Name', 'trim|required'),
	array('Address', 'Address', 'trim|required'),
);