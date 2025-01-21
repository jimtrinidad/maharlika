<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Delivery extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // require login
        check_authentication();
    }

    public function agents()
    {
        $viewData = array(
            'pageTitle'         => 'Delivery Agents',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details(),
            'jsModules'         => array(
                'delivery'
            )
        );

        $results = $this->appdb->getRecords('DeliveryAgents', array(), 'Status, id DESC');
        $records = array();
        foreach ($results as $r) {
            $user = $this->appdb->getRowObject('Users', $r['UserID']);
            if ($user) {
                unset($user->Password);
                $r['accountData'] = $user;

                $records[$r['Code']] = $r;
            }
        }
        $viewData['records']   = $records;

        view('pages/delivery/agents', $viewData, 'templates/main');
    }

    public function save_agent_status()
    {

        if (validate('verify_delivery_agent') == FALSE) {
            $return_data = array(
                'status'    => false,
                'message'   => 'Some fields have errors.',
                'fields'    => validation_error_array()
            );
        } else {

            $agent = $this->appdb->getRowObject('DeliveryAgents', get_post('Code'), 'Code');
            if ($agent) {

                $updateData = array(
                    'id'           => $agent->id,
                    'Status'       => get_post('agent_status'),
                    'ManType'      => get_post('agent_man_type'),
                    'LastUpdate'   => datetime(),
                );

                if ($this->appdb->saveData('DeliveryAgents', $updateData)) {
                    $return_data = array(
                        'status'    => true,
                        'message'   => 'Delivery Agent status has been updated.'
                    );
                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Updating agent status failed.'
                    );
                }

            } else {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'Invalid agent data'
                );
            }

        }

        response_json($return_data);
    }

    public function decline_agent_application($code)
    {
        if (!$code) {
            $code = get_post('code');
        }

        $agent = $this->appdb->getRowObject('DeliveryAgents', $code, 'Code');
        if ($agent) {

            if ($agent->Status == 0) {

                if ($this->appdb->deleteData('DeliveryAgents', $agent->id)) {
                    $docs = json_decode($agent->Requirements);
                    foreach ($docs as $doc) {
                        @unlink(UPLOADS_DIRECTORY . $doc);
                    }
                    $return_data = array(
                        'status'    => true,
                        'message'   => 'Agent application has been declined.'
                    );
                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Declining application failed.'
                    );
                }

            } else {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'Invalid agent data'
                );
            }
        } else {
            $return_data = array(
                'status'    => false,
                'message'   => 'Invalid agent data'
            );
        }

        response_json($return_data);
    }

}
