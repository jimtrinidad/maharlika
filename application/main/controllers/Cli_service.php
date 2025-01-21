<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

set_time_limit(0);

class Cli_service extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		//i cant run email via command line
		// i'll just call via curl and change class and method to random name

		if (! $this->input->is_cli_request())
			show_404();

		$this->load->library('email');

	}

	public function index()
	{
		// Huh?
		show_404();
	}

	public function send_email_queue()
	{
		$this->email->send_queue();
	}

	public function resend_failed_email()
	{
		$this->email->retry_queue();
	}

	/*
	* check paid eclink payments
	* add paid request to user wallet
	*/
	public function check_committed_payments()
	{
		$commits = $this->appdb->getRecords('ECLinkPayments', array('Status' => 0));
		foreach ($commits as $commit) {
			print_r($commit);
			if (time() < strtotime($commit['Expiration'])) {
				// check payment status on ecpay api
				$ecparams   = array(
					'referenceno' => $commit['ReferenceNo'],
				);
				$ecresponse = $this->ecpay->eclink_confirm_payment($ecparams);
				if ($ecresponse) {
					print_r($ecresponse);
					// check payment status
					if (isset($ecresponse['PaymentStatus']) && $ecresponse['PaymentStatus'] === 0) {
						// add amount to user wallet
						$updateData = array(
							'id'           => $commit['id'],
							'Status'       => 1,
							'LastModified' => datetime()
						);
		
						$this->db->trans_begin();
		
						if ($this->appdb->saveData('ECLinkPayments', $updateData)) {
							$latest_balance = get_latest_wallet_balance($commit['AccountID']);
							$new_balance    = $latest_balance + $commit['Amount'];
		
							$transactionData = array(
								'Code'          => $commit['Code'],
								'AccountID'     => $commit['AccountID'],
								'ReferenceNo'   => $commit['ReferenceNo'],
								'Date'          => date('Y-m-d h:i:s'),
								'Description'   => 'Fund my wallet - Via Payment Outlet',
								'Amount'        => $commit['Amount'],
								'Type'          => 'Credit',
								'EndingBalance' => $new_balance
							);
		
							if ($this->appdb->saveData('WalletTransactions', $transactionData)) {
								logger('[ECLinkPayments] ' . $commit['ReferenceNo'] . ' - has been credited.');
								$this->db->trans_commit();
							} else {
								logger('[ECLinkPayments] ' . $commit['ReferenceNo'] . ' - saving transaction failed.');
								$this->db->trans_rollback();
							}
						} else {
							logger('[ECLinkPayments] ' . $commit['ReferenceNo'] . ' - updating payment failed.');
						}
					}
				}
			} else {
				$updateParams = array(
					'id'		 	=> $commit['id'],
					'Status'	 	=> 2,
					'LastModified' 	=> datetime()
				);
				if ($this->appdb->saveData('ECLinkPayments', $updateParams)) {
					logger('[ECLinkPayments] ' . $commit['ReferenceNo'] . ' - expired.');
				} else {
					logger('[ECLinkPayments] ' . $commit['ReferenceNo'] . ' - update failed');
				}
			}
		}
	}
}