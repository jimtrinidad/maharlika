<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deposits extends CI_Controller
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
            'pageTitle'         => 'Deposit',
            'pageDescription'   => '',
            'accountInfo'       => user_account_details(),
            'jsModules'         => array(
                'wallet'
            )
        );

        $records = $this->appdb->getRecords('WalletDeposits', array(), 'Status, id DESC');
        foreach ($records as &$r) {
            $user = $this->appdb->getRowObject('Users', $r['AccountID']);
            $r['accountData'] = array(
                'Firstname'     => $user->Firstname,
                'Lastname'      => $user->Lastname
            );
        }
        $viewData['records']   = $records;

        // print_data($viewData);

        view('pages/deposits/index', $viewData, 'templates/main');
    }

    public function confirm_deposit($code = null)
    {
        if (!$code) {
            $code = get_post('code');
        }

        $deposit = $this->appdb->getRowObject('WalletDeposits', $code, 'Code');
        if ($deposit) {

            if ($deposit->Status == 0) {
                $updateData = array(
                    'id'           => $deposit->id,
                    'Status'       => 1,
                    'UpdatedBy'    => current_user(),
                    'VerifiedDate' => date('Y-m-d H:i:s')  
                );

                $this->db->trans_begin();

                if ($this->appdb->saveData('WalletDeposits', $updateData)) {
                    $latest_balance = get_latest_wallet_balance($deposit->AccountID);
                    $new_balance    = $latest_balance + $deposit->Amount;

                    $transactionData = array(
                        'Code'          => $deposit->Code,
                        'AccountID'     => $deposit->AccountID,
                        'ReferenceNo'   => $deposit->ReferenceNo,
                        'Date'          => date('Y-m-d h:i:s'),
                        'Description'   => 'Fund my wallet - ' . $deposit->Bank . ' - ' . $deposit->Branch,
                        'Amount'        => $deposit->Amount,
                        'Type'          => 'Credit',
                        'EndingBalance' => $new_balance
                    );

                    if ($this->appdb->saveData('WalletTransactions', $transactionData)) {
                        $this->db->trans_commit();
                        $return_data = array(
                            'status'    => true,
                            'message'   => 'Deposit transaction has been posted.'
                        );
                    } else {
                        $this->db->trans_rollback();

                        $return_data = array(
                            'status'    => false,
                            'message'   => 'Saving transaction failed.'
                        );
                    }
                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Verifying deposit failed.'
                    );
                }

            } else {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'Deposit request was already verified and credited.'
                );
            }
        } else {
            $return_data = array(
                'status'    => false,
                'message'   => 'Invalid deposit transaction'
            );
        }

        response_json($return_data);
    }

    public function decline_deposit($code = null)
    {
        if (!$code) {
            $code = get_post('code');
        }

        $deposit = $this->appdb->getRowObject('WalletDeposits', $code, 'Code');
        if ($deposit) {

            if ($deposit->Status == 0) {
                $updateData = array(
                    'id'           => $deposit->id,
                    'Status'       => 2,
                    'UpdatedBy'    => current_user(), 
                );

                if ($this->appdb->saveData('WalletDeposits', $updateData)) {
                    $return_data = array(
                        'status'    => true,
                        'message'   => 'Deposit request has been declined successfully.'
                    );
                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Declining deposit failed.'
                    );
                }

            } else {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'Deposit request was voided already.'
                );
            }
        } else {
            $return_data = array(
                'status'    => false,
                'message'   => 'Invalid deposit transaction'
            );
        }

        response_json($return_data);
    }

}
