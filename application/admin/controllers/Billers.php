<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billers extends CI_Controller
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
            'pageTitle'         => 'Billers',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details(),
            'jsModules'         => array(
                'general'
            )
        );

        $where = array(
            'Status'    => 1
        );

                // SET SEARCH FILTER
        $filters = array(
            'search_name',
            'search_biller_type'
        );

        foreach ($filters as $filter) {

            $$filter = get_post($filter);

            if ($filter == 'search_name' && $$filter != false) {
                $where['CONCAT(Name, " ", BillerTag, " ", Description) LIKE ']  = "%{$search_name}%";
            } else if ($filter == 'search_biller_type' && $$filter != '') {
                $where['Type']  = $search_biller_type;
            }

            // search params
            $viewData[$filter] = $$filter;

        }

        $viewData['billers'] = $this->appdb->getRecords('Billers', $where, 'Name');

        view('pages/billers/index', $viewData, 'templates/main');

    }

    public function update_biller()
    {
        $billers = $this->ecpay->get_billers();
        if ($billers) {
            $savedBillers   = $this->appdb->getRecords('Billers');
            $active_billers = array();
            foreach ($billers as $biller) {
                print_r($biller);
                $billerData = $this->appdb->getRowObject('Billers', md5($biller['BillerTag']), 'Code');

                $saveData = array(
                        'LastUpdate'    => datetime()
                    );

                $saveData = array_merge($biller, $saveData);

                if (!$billerData) {
                    $saveData['Code'] = md5($biller['BillerTag']);
                    $saveData['Name'] = $biller['BillerTag'];
                    $saveData['Type'] = 1;
                } else {
                    $saveData['id']   = $billerData->id;
                    $active_billers[] = $billerData->Code;
                }

                $this->appdb->saveData('Billers', $saveData);
            }

            // print_data($active_billers);
            // print_data($savedBillers);

            foreach ($savedBillers as $b) {
                if (in_array($b['Code'], $active_billers)) {
                    $status = 1;
                } else {
                    $status = 0;
                    logger('Biller -> ' . $b['BillerTag'] . ' is no longer active.');
                }

                $this->appdb->saveData('Billers', array(
                    'Status' => $status,
                    'id'     => $b['id']
                ));
            }
        }
    }

    public function save_biller_logo()
    {

        $billerData = $this->appdb->getRowObject('Billers', get_post('Code'), 'Code');
        if ($billerData) {
            $randomLogoName = md5(microsecID());

            // validate file upload
            $this->load->library('upload', array(
                'upload_path'   => LOGO_DIRECTORY,
                'allowed_types' => 'gif|jpg|png',
                // 'max_size'      => '1000', // 1mb
                // 'max_width'     => '1024',
                // 'max_height'    => '768',
                'overwrite'     => true,
                'file_name'     => $randomLogoName
            ));

            if (!empty($_FILES['Logo']['name']) && $this->upload->do_upload('Logo') == false) {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'Uploading image failed.',
                    'fields'    => array('Logo' => $this->upload->display_errors('',''))
                );
            } else {

                // do save
                $uploadData     = $this->upload->data();

                $saveData = array(
                    'id'            => $billerData->id,
                    'Name'          => get_post('biller_name'),
                    'Type'          => get_post('biller_type'),
                    'LastUpdate'    => date('Y-m-d H:i:s')
                );

                if (!empty($_FILES['Logo']['name'])) {
                    $saveData['Image'] = $uploadData['file_name'];
                }

                if (($ID = $this->appdb->saveData('Billers', $saveData))) {

                    // delete old logo if edited
                    if (isset($saveData['Image']) && !empty($billerData->Image)) {
                        @unlink(LOGO_DIRECTORY . $billerData->Image);
                    }

                    $return_data = array(
                        'status'    => true,
                        'message'   => 'Biller logo has been saved.',
                        'id'        => $ID
                    );
                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Saving logo failed. Please try again later.'
                    );
                }

            }

        } else {
            $return_data = array(
                'status'    => false,
                'message'   => 'Invalid biller data.'
            );
        }

        response_json($return_data);
    }



    public function ecash_services()
    {
        $viewData = array(
            'pageTitle'         => 'Ecash Services',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details(),
            'jsModules'         => array(
                'general'
            )
        );

        $viewData['services'] = $this->appdb->getRecords('EcashServices', array('Status' => 1), 'Name');

        view('pages/billers/ecash_services', $viewData, 'templates/main');

    }

    public function update_ecash_services()
    {
        $data = $this->ecpay->get_ecash_providers();
        print_r($data);
        if ($data) {
            $savedItems   = $this->appdb->getRecords('EcashServices');
            $active_data = array();
            foreach ($data as $item) {
                $itemData = $this->appdb->getRowObject('EcashServices', md5($item['Services']), 'Code');

                $saveData = array(
                        'LastUpdate'    => datetime()
                    );

                $saveData = array_merge($item, $saveData);

                if (!$itemData) {
                    $saveData['Name'] = $item['Services'];
                    $saveData['Code'] = md5($item['Services']);
                } else {
                    $saveData['id']   = $itemData->id;
                    $active_data[]    = $itemData->Code;
                }

                $this->appdb->saveData('EcashServices', $saveData);
            }

            foreach ($savedItems as $b) {
                if (in_array($b['Code'], $active_data)) {
                    $status = 1;
                } else {
                    $status = 0;
                    logger('Ecash Services -> ' . $b['Name'] . ' is no longer active.');
                }

                $this->appdb->saveData('EcashServices', array(
                    'Status' => $status,
                    'id'     => $b['id']
                ));
            }
        }
    }


    public function save_ecash_service()
    {

        $data = $this->appdb->getRowObject('EcashServices', get_post('Code'), 'Code');
        if ($data) {
            $randomLogoName = md5(microsecID());

            // validate file upload
            $this->load->library('upload', array(
                'upload_path'   => LOGO_DIRECTORY,
                'allowed_types' => 'gif|jpg|png',
                // 'max_size'      => '1000', // 1mb
                // 'max_width'     => '1024',
                // 'max_height'    => '768',
                'overwrite'     => true,
                'file_name'     => $randomLogoName
            ));

            if (!empty($_FILES['Logo']['name']) && $this->upload->do_upload('Logo') == false) {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'Uploading image failed.',
                    'fields'    => array('Logo' => $this->upload->display_errors('',''))
                );
            } else {

                // do save
                $uploadData     = $this->upload->data();

                $saveData = array(
                    'id'            => $data->id,
                    'Name'          => get_post('service_name'),
                    'Description'   => get_post('service_description'),
                    'LastUpdate'    => date('Y-m-d H:i:s')
                );

                if (!empty($_FILES['Logo']['name'])) {
                    $saveData['Image'] = $uploadData['file_name'];
                }

                if (($ID = $this->appdb->saveData('EcashServices', $saveData))) {

                    // delete old logo if edited
                    if (isset($saveData['Image']) && !empty($data->Image)) {
                        @unlink(LOGO_DIRECTORY . $data->Image);
                    }

                    $return_data = array(
                        'status'    => true,
                        'message'   => 'Ecash service has been saved.',
                        'id'        => $ID
                    );
                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Saving failed. Please try again later.'
                    );
                }

            }

        } else {
            $return_data = array(
                'status'    => false,
                'message'   => 'Invalid data.'
            );
        }

        response_json($return_data);
    }



    /**
    * TELCO
    */
    public function update_telco_topups()
    {
        $data = $this->ecpay->get_telco_topups();
        if ($data) {
            $savedItems   = $this->appdb->getRecords('TelcoTopUps');
            $active_data = array();
            foreach ($data as $item) {
                if (isset($item['TelcoTag']) && isset($item['TelcoName'])) {
                    $code     = md5($item['TelcoTag'] . $item['TelcoName'] . $item['Denomination'] . $item['ExtTag']);
                    $itemData = $this->appdb->getRowObject('TelcoTopUps', $code, 'Code');

                    $saveData = array(
                            'LastUpdate'    => datetime()
                        );

                    $saveData = array_merge($item, $saveData);

                    if (!$itemData) {
                        $saveData['Code'] = $code;
                    } else {
                        $saveData['id']   = $itemData->id;
                        $active_data[]    = $itemData->Code;
                    }

                    print_r($saveData);

                    $this->appdb->saveData('TelcoTopUps', $saveData);
                }
            }

            foreach ($savedItems as $b) {
                if (in_array($b['Code'], $active_data)) {
                    $status = 1;
                } else {
                    $status = 0;
                    logger('Telco Topups -> ' . $b['TelcoTag'] . ' is no longer active.');
                }

                $this->appdb->saveData('TelcoTopUps', array(
                    'Status' => $status,
                    'id'     => $b['id']
                ));
            }
        }
    }

    public function telco_topups()
    {
        $viewData = array(
            'pageTitle'         => 'Telco Topups',
            'pageDescription'   => '',
            'content_header'    => false,
            'accountInfo'       => user_account_details(),
            'jsModules'         => array(
                'general'
            )
        );

        $where = array(
            'Status'    => 1
        );

                // SET SEARCH FILTER
        $filters = array(
            'search_name',
            'search_telco'
        );

        foreach ($filters as $filter) {

            $$filter = get_post($filter);

            if ($filter == 'search_name' && $$filter != false) {
                $where['TelcoTag LIKE ']  = "%{$search_name}%";
            } else if ($filter == 'search_telco' && $$filter != '') {
                $where['TelcoName']  = $search_telco;
            }

            // search params
            $viewData[$filter] = $$filter;

        }

        $viewData['services'] = $this->appdb->getRecords('TelcoTopUps', $where, 'TelcoName, TelcoTag, (Denomination * 1)');

        view('pages/billers/telco_topups', $viewData, 'templates/main');

    }

}
