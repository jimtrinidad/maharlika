<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // require login
        check_authentication();
    }

    public function invoice($code = false)
    {
        $viewData = array(
            'pageTitle'     => 'Orders',
            'pageSubTitle'  => 'ORDER SUMMARY',
            'accountInfo'   => user_account_details(),
            'jsModules'     => array(
            ),
        );

        $orderData = $this->appdb->getRowObjectWhere('Orders', array('OrderBy' => current_user(), 'Code' => $code));

        if ($orderData) {

            $userData       = $this->appdb->getRowObject('Users', $orderData->OrderBy);
            $addressData    = $this->appdb->getRowObject('UserAddress', $orderData->AddressID);
            $orderItems     = $this->appdb->getRecords('OrderItems', array('OrderID' => $orderData->id));

            $addressData->data = lookup_address($addressData);

            $orderData->Distribution = json_decode($orderData->Distribution);

            $agent = false;

            if ($orderData->DeliveryMethod == 2 && $orderData->DeliveryAgent) {
                $agentData       = $this->appdb->getRowObject('Users', $orderData->DeliveryAgent);
                if ($agentData) {
                    $agent = (object) array(
                        'name'      => $agentData->Firstname . ' ' . $agentData->Lastname,
                        'photo'     => photo_filename($agentData->Photo),
                        'email'     => $agentData->EmailAddress,
                        'mobile'    => ($agentData->DialCode ? '+' . $agentData->DialCode : '') . $agentData->Mobile,
                        'id'        => $agentData->PublicID
                    );
                }
            }

            $viewData['agent'] = $agent;

            $viewData['orderData']  = $orderData;
            $viewData['userData']   = $userData;
            $viewData['address']    = $addressData;
            $viewData['items']      = $orderItems;

            // print_data($viewData);

            view('main/order/invoice', $viewData, 'templates/main');
        } else {
            redirect();
        }

    }

}
