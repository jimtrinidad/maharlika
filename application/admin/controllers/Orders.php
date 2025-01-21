<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
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
            'pageTitle'         => 'Orders',
            'pageDescription'   => '',
            'accountInfo'       => user_account_details(false, false),
            'jsModules'         => array(
                'general'
            )
        );

        $records = $this->appdb->getRecords('Orders', array(), 'Status, id DESC');
        foreach ($records as &$r) {
            $user = $this->appdb->getRowObject('Users', $r['OrderBy']);
            $r['user'] = (object) array(
                'Firstname' => $user->Firstname,
                'Lastname'  => $user->Lastname
            );

            $agent          = 0; // not needed

            if ($r['DeliveryMethod'] == 2) {
                // $agent = 1; // not set
                if ($r['DeliveryAgent']) {
                    $adata = $this->appdb->getRowObject('Users', $r['DeliveryAgent']);
                    if ($adata) {
                        $r['agentData'] = (object) array(
                            'Firstname' => $adata->Firstname,
                            'Lastname'  => $adata->Lastname
                        );


                        $agent = 3;
                    }
                }

            }

            $r['agent'] = $agent;

        }
        $viewData['records']   = $records;

        // print_data($viewData);

        view('pages/orders/index', $viewData, 'templates/main');
    }

    // view invoice on modal
    public function invoice($code = '')
    {
        $orderData = $this->appdb->getRowObject('Orders', $code, 'Code');

        if ($orderData) {

            $viewData       = array();
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


            echo view('pages/orders/invoice', $viewData, null, true);

        }

        return '';

    }


    public function update_status()
    {
        $code = post('Code');
        $orderData = $this->appdb->getRowObject('Orders', $code, 'Code');
        if ($orderData) {

            $status = post('order_status');

            if ($status != $orderData->Status) {

                if ($orderData->Status <= 3) {

                    $this->db->trans_begin();

                    $saveData = array(
                        'id'            => $orderData->id,
                        'LastUpdate'    => datetime()
                    );

                    if ($status == 4) {
                        // complete order
                        // distribute rewards
                        if (distribute_order_rewards($orderData->id)) {
                            $saveData['Status'] = $status;
                        }

                    } else if ($status == 5) {
                        // cancel order
                        // return payment
                        if (refund_order($orderData->id)) {
                            $saveData['Status'] = $status;
                        }
                    } else {
                        // just update the status
                        $saveData['Status'] = $status;
                    }

                    if (isset($saveData['Status'])) {

                        if (record_order_status($orderData->id, $status, post('status_remarks'))) {

                            if ($this->appdb->saveData('Orders', $saveData)) {
                                $this->db->trans_commit();
                                $return_data = array(
                                    'status'    => true,
                                    'message'   => 'Order has been updated.'
                                );
                            } else {
                                $this->db->trans_rollback();
                                $return_data = array(
                                    'status'    => false,
                                    'message'   => 'Updating order failed.'
                                );
                            }

                        } else {
                            $return_data = array(
                                'status'    => false,
                                'message'   => 'Updating order status failed.'
                            );
                        }
                    }

                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Order was already completed or canceled before.'
                    );
                }

            } else {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'No changes made.'
                );
            }

        } else {
            $return_data = array(
                'status'    => false,
                'message'   => 'Invalid order.'
            );
        }

        response_json($return_data);
    }

    public function get_order_status($code)
    {

        $order = $this->appdb->getRowObjectWhere('Orders', array('Code' => $code));
        if ($order) {
            $items   = $this->appdb->getRecords('OrderStatus', array('OrderID' => $order->id), 'id');
            foreach ($items as &$i) {
                $i['Status']   = lookup('order_status', $i['Status']);
                $i['Datetime'] = date('m/d/y H:i', strtotime($i['Datetime']));
                if ($i['Image']) {
                    $i['Image'] = public_url('assets/uploads/') . upload_filename($i['Image']);
                } else {
                    $i['Image'] = false;
                }

                $user    = $this->appdb->getRowObject('Users', $i['UpdatedBy']);
                if ($user) {
                    $i['UpdatedBy'] = $user->Firstname . ' ' . $user->Lastname;
                }
            }
            $return_data = array(
                'status'  => true,
                'data'    => $items
            );
        } else {
            $return_data = array(
                'status'    => false,
                'message'   => 'Invalid order'
            );
        }
        response_json($return_data);
    }

}
