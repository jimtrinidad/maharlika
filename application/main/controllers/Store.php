<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // require login
        check_authentication();
    }

    public function index($code = null)
    {
        $viewData = array(
            'pageTitle'     => 'Store',
            'pageSubTitle'  => 'Ambilis ng Business ko!',
            'accountInfo'   => user_account_details(),
            'jsModules'         => array(
                'store',
                'general'
            ),
        );

        $storeData  = $this->appdb->getRowObject('StoreDetails', current_user(), 'OwnerID');
        $storeItems = array();

        if ($storeData) {
            $storeItems  = $this->appdb->getRecords('StoreItems', array('StoreID' => $storeData->id));
            $addressData = lookup_address($storeData);
            $viewData['address'] = ucwords(strtolower(trim(($storeData->Address . (isset($addressData['Barangay']) ? ', ' . $addressData['Barangay'] : '') . (isset($addressData['MuniCity']) ? ', ' . $addressData['MuniCity'] : '')), ', ')));
        }

        // print_data($viewData,true);

        $viewData['items']     = $storeItems;
        $viewData['StoreData'] = $storeData;

        $categories  = lookup_all('ProductCategories', false, 'Name', false);
        $sub_cat_rsp = lookup_all('ProductSubCategories', false, 'Name', false);
        $sub_categories = array();
        foreach ($sub_cat_rsp as $i) {
            $sub_categories[$i['CategoryID']][] = $i;
        }

        $viewData['categories']     = $categories;
        $viewData['sub_categories'] = $sub_categories;
        view('main/store/index', $viewData, 'templates/main');
    }

    public function update()
    {

        if (validate('save_store_profile') == FALSE) {
            $return_data = array(
                'status'    => false,
                'message'   => 'Some fields have errors.',
                'fields'    => validation_error_array()
            );
        } else {

            $slug = slugit(get_post('Name'));
            $slug_exists = $this->appdb->getRowObject('StoreDetails', $slug, 'Slug');
            $StoreData   = $this->appdb->getRowObject('StoreDetails', current_user(), 'OwnerID');

            if (!$slug_exists || ($slug_exists && $slug_exists->OwnerID == current_user())) {

                $updateData = array(
                    'Name'      => get_post('Name'),
                    'Address'   => get_post('Address'),
                    'Contact'   => get_post('Contact'),
                    'Email'     => get_post('Email'),
                    'Slug'      => $slug,
                    'MinimumOrder' => get_post('MinimumOrder'),
                    'Province'  => get_post('SDProvince'),
                    'City'      => get_post('SDCity'),
                    'Barangay'  => get_post('SDBarangay'),
                    'LastUpdate'=> datetime()
                );

                if ($StoreData) {
                    $updateData['id'] = $StoreData->id;
                } else {
                    $updateData['Code']     = microsecID();
                    $updateData['OwnerID']  = current_user();
                    $updateData['Status']   = 0;
                }

                if (($ID = $this->appdb->saveData('StoreDetails', $updateData))) {
                    $return_data = array(
                        'status'    => true,
                        'message'   => 'Store profile has been updated.',
                        'id'        => $ID
                    );
                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Saving profile failed. Please try again later.'
                    );
                }

            } else {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'Some fields have errors.',
                    'fields'    => array(
                                'Name'  => 'Store name already exists'
                            )
                );
            }

        }

        response_json($return_data);
    }

    public function saveitem()
    {
        if (validate('save_store_item') == FALSE) {
            $return_data = array(
                'status'    => false,
                'message'   => 'Some fields have errors.',
                'fields'    => validation_error_array()
            );
        } else {

            $Store = $this->appdb->getRowObject('StoreDetails', current_user(), 'OwnerID');
            if ($Store) {

                $itemData = $this->appdb->getRowObject('StoreItems', get_post('Code'), 'Code');

                $upload_status = true;
                $uploadData    = array();
                $uploadErrors  = array();

                $this->load->library('upload');

                if(!empty($_FILES['Image']['name'])) {
                    foreach ($_FILES['Image']['name'] as $i => $name) {

                        // require on new item
                        if (!$itemData) {
                            if (empty($_FILES['Image']['name'][$i])) {
                                $uploadErrors[$i] = $i . ' image is required.';
                                $upload_status = false;
                                continue;
                            }
                        }

                        $randomLogoName = md5(random_letters());

                        // validate file upload
                        $config = array(
                            'upload_path'   => PRODUCTS_DIRECTORY,
                            'allowed_types' => 'gif|jpg|png',
                            // 'max_size'      => '1000', // 1mb
                            // 'max_width'     => '1024',
                            // 'max_height'    => '768',
                            'overwrite'     => true,
                            'file_name'     => $randomLogoName
                        );
                        $this->upload->initialize($config);

                        $_FILES['userFile']['name'] = $_FILES['Image']['name'][$i];
                        $_FILES['userFile']['type'] = $_FILES['Image']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['Image']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['Image']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['Image']['size'][$i];

                        if (!empty($_FILES['userFile']['name']) && $this->upload->do_upload('userFile') == false) {
                            $uploadErrors[$i] = $this->upload->display_errors('','');
                            $upload_status = false;
                        } else {
                            if (!empty($_FILES['userFile']['name'])) {
                                $fileData = $this->upload->data();
                                $uploadData[$i]['file_name'] = $fileData['file_name'];
                            }
                        }

                    }
                }

                if ($upload_status) {

                    $saveData = array(
                        'Category'          => get_post('Category'),
                        'SubCategory'       => get_post('SubCategory'),
                        'Name'              => get_post('Name'),
                        'Description'       => get_post('Description'),
                        'Measurement'       => get_post('Measurement'),
                        'Price'             => get_post('Price'),
                        'CommissionType'    => get_post('CommissionType'),
                        'CommissionValue'   => get_post('CommissionValue'),
                        'Manufacturer'      => get_post('Manufacturer'),
                        'ModelName'         => get_post('ModelName'),
                        'MinimumQuantity'   => get_post('MinimumQuantity'),
                        'Stock'             => get_post('Stock'),
                        'DeliveryMethod'    => get_post('DeliveryMethod'),
                        'Warranty'          => get_post('Warranty'),
                        'SearchKeywords'    => get_post('SearchKeywords'),
                        'Weight'            => get_post('Weight'),
                        'WeightUnit'        => get_post('WeightUnit'),
                        'LastUpdate'        => date('Y-m-d H:i:s')
                    );

                    if (isset($uploadData['ProductImage'])) {
                        $saveData['Image'] = $uploadData['ProductImage']['file_name'];
                    }
                    if (isset($uploadData['PartnerImage'])) {
                        $saveData['PartnerImage'] = $uploadData['PartnerImage']['file_name'];
                    }

                    if ($itemData) {
                        $saveData['id'] = $itemData->id;
                    } else {
                        $saveData['Code']        = microsecID(true);
                        $saveData['StoreID']     = $Store->id;
                    }

                    if (($ID = $this->appdb->saveData('StoreItems', $saveData))) {

                        // delete old logo if edited
                        if ($itemData !== false && isset($saveData['Image'])) {
                            @unlink(PRODUCTS_DIRECTORY . $itemData->Image);
                        }

                        $return_data = array(
                            'status'    => true,
                            'message'   => 'Store product has been saved.',
                            'id'        => $ID
                        );
                    } else {
                        $return_data = array(
                            'status'    => false,
                            'message'   => 'Saving product failed. Please try again later.'
                        );
                    }

                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Uploading image failed.',
                        'fields'    => $uploadErrors
                    );
                }

            } else {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'Store data not found.'
                );
            }
        }

        response_json($return_data);
    }

    public function deleteitem($id = null)
    {
        $itemData = $this->appdb->getRowObject('StoreItems', $id, 'Code');
        if ($itemData) {

            if ($this->appdb->deleteData('StoreItems', $itemData->id)) {

                @unlink(PRODUCTS_DIRECTORY . $itemData->Image);
                
                response_json(array(
                    'status'    => true,
                    'message'   => 'Item has been deleted.'
                ));

            } else {
                response_json(array(
                    'status'    => false,
                    'message'   => 'Deleting item failed.'
                ));
            }
        } else {
            response_json(array(
                'status'    => false,
                'message'   => 'Invalid item.'
            ));
        }

    }



    public function locations()
    {

        $address = $this->appdb->getRecords('StoreLocations', array('UserID' => current_user()), 'Province');
        $items   = array();
        foreach ($address as $i) {
            $i['names'] = lookup_address($i);
            $items[$i['id']] = $i;
        }
        $return_data = array(
            'status'  => true,
            'data'    => $items
        );
        response_json($return_data);
    }

    public function save_location()
    {

        $storeData  = $this->appdb->getRowObject('StoreDetails', current_user(), 'OwnerID');

        if ($storeData) {
            if (validate('store_address') == FALSE) {
                $return_data = array(
                    'status'    => false,
                    'message'   => 'Some fields have errors.',
                    'fields'    => validation_error_array()
                );
            } else {

                $exists = $this->appdb->getRowObjectWhere('StoreLocations', array(
                    'Barangay'          => get_post('SAddressBarangay'),
                    'City'              => get_post('SAddressCity'),
                    'Province'          => get_post('SAddressProvince'),
                    'UserID'            => current_user()
                ));

                if (!$exists || ($exists  && $exists->id == get_post('SAddressID'))) {

                    $saveData     = array(
                        'Street'            => get_post('SAddressStreet'),
                        'Barangay'          => get_post('SAddressBarangay'),
                        'City'              => get_post('SAddressCity'),
                        'Province'          => get_post('SAddressProvince'),
                        'LastUpdate'        => datetime(),
                    );

                    $addressData = $this->appdb->getRowObject('StoreLocations', get_post('SAddressID'));
                    if ($addressData) {
                        $saveData['id'] = $addressData->id;
                    } else {
                        $saveData['UserID'] = current_user();
                        $saveData['StoreID']= $storeData->id;
                    }

                    if (($ID = $this->appdb->saveData('StoreLocations', $saveData))) {
                        $return_data = array(
                            'status'    => true,
                            'message'   => 'Location has been saved successfully.',
                            'id'        => $ID
                        );
                    } else {
                        $return_data = array(
                            'status'    => false,
                            'message'   => 'Saving failed. Please try again later.'
                        );
                    }

                } else {
                    $return_data = array(
                        'status'    => false,
                        'message'   => 'Location already exists.'
                    );
                }
            }
        } else {
            $return_data = array(
                'status'    => false,
                'message'   => 'Store data not found.'
            );
        }

        response_json($return_data);
    }


    public function delete_location($id = null)
    {

        $itemData = $this->appdb->getRowObjectWhere('StoreLocations', array('id' => $id, 'UserID' => current_user()));
        if ($itemData) {

            if ($this->appdb->deleteData('StoreLocations', $itemData->id)) {
                
                response_json(array(
                    'status'    => true,
                    'message'   => 'Location has been deleted.'
                ));

            } else {
                response_json(array(
                    'status'    => false,
                    'message'   => 'Deleting failed.'
                ));
            }

        } else {
            response_json(array(
                'status'    => false,
                'message'   => 'Invalid item.'
            ));
        }

    }

}
