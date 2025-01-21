<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ECPay Class
 *
 * ECPay SOAP API Wrapper.
 *
 * @package        ECPay
 * @version        1.0
 * @author         Jim Trinidad <jimtrinidad002@gmail.com>
 *
 */
class Ecpay
{

    /**
     * CodeIgniter
     *
     * @access    private
     */
    private $ci;

    /**
     * Config items
     *
     * @access    private
     */
    public $branch_id;
    public $account_id;
    public $username;
    public $password;

    public $default_host = 's2s.oneecpay.com';

    public $post_urls   = array();

    public $debug = false;

    /**
     * Constructor
     */
    public function __construct()
    {

        // Assign CodeIgniter object to $this->ci
        $this->ci = &get_instance();

        // Load config
        $this->ci->config->load('ecpay');
        $authentication_config = $this->ci->config->item('authentication');

        // Set config items
        $this->branch_id    = $authentication_config['branch_id'];
        $this->account_id   = $authentication_config['account_id'];
        $this->username     = $authentication_config['username'];
        $this->password     = $authentication_config['password'];
        // $this->mc           = 'AMBILIS';
        // $this->mk           = '06689C5EF7ED43C7911C8612873FC90E';
        $this->mc           = 'AMBILIS_MO';
        $this->mk           = '741989AF834CRAMF6E9B0FC7B99EBE29';

        $this->post_urls    = array(
            'bills'     => 'https://s2s.oneecpay.com/wsbillpay/',
            'ecash'     => 'https://s2s.oneecpay.com/wsecash/',
            'telco'     => 'https://s2s.oneecpay.com/wstopupv2/',
            'link'      => 'https://s2s.oneecpay.com/eclink/',
            // 'link'      => 'https://myecpay.ph/webservice/ECLINK/', // test server
        );

    }

    /**
     * get billers
     */
    public function get_billers()
    {
        $params = array(
            'post_url'  => $this->post_urls['bills'],
            'action'    => 'http://tempuri.org/ECPNBillsPayment/Service1/GetBillerList'
        );
        $body   = '<GetBillerList xmlns="http://tempuri.org/ECPNBillsPayment/Service1">' .
                    $this->default_body_params() .
                  '</GetBillerList>';

        $response = $this->request($params, $body);

        if (isset($response->GetBillerListResponse)) {
            $items    = json_decode(json_encode($response->GetBillerListResponse->GetBillerListResult), true);

            if ($items['BStruct'][0]['BillerTag'] != 'ERROR') {

                $billers = array();
                foreach ($items['BStruct'] as $item) {
                    $billers[] = $item;
                }

                return $billers;

            } else {
                logger('[get_billers] : ' . $items['BStruct'][0]['Description']);
            }

        } else {
            logger('[get_billers] : Cannot connect to host.');
        }

        return false;
    }

    /**
    * Validate billers account
    */
    public function validate_biller_account($fields = array())
    {
        $params = array(
            'post_url'  => $this->post_urls['bills'],
            'action'    => 'http://tempuri.org/ECPNBillsPayment/Service1/ValidateAccount'
        );

        $other_fields = '';
        foreach ($fields as $k => $v) {
            $other_fields .= "<{$k}>{$v}</$k>\n";
        }

        $body   = '<ValidateAccount xmlns="http://tempuri.org/ECPNBillsPayment/Service1">' .
                    $this->default_body_params() .
                    $other_fields .
                  '</ValidateAccount>';

        $response = $this->request($params, $body);

        if (isset($response->ValidateAccountResponse)) {
            $items    = json_decode(json_encode($response->ValidateAccountResponse->ValidateAccountResult), true);
            return $items;
        } else {
            logger('[validate_biller_account] : Cannot connect to host.');
        }

        return false;
    }

    /**
    * Transact bills payment
    */
    public function bills_payment_transact($fields = array())
    {
        $params = array(
            'post_url'  => $this->post_urls['bills'],
            'action'    => 'http://tempuri.org/ECPNBillsPayment/Service1/Transact'
        );

        $other_fields = '';
        foreach ($fields as $k => $v) {
            $other_fields .= "<{$k}>{$v}</$k>\n";
        }

        $body   = '<Transact xmlns="http://tempuri.org/ECPNBillsPayment/Service1">' .
                    $this->default_body_params(true) .
                    $other_fields .
                  '</Transact>';

        $response = $this->request($params, $body);

        if (isset($response->TransactResponse)) {
            $items    = json_decode(json_encode($response->TransactResponse->TransactResult), true);
            return $items;
        } else {
            logger('[bills_payment_transact] : Cannot connect to host.');
        }

        return false;
    }

    // END BILLERS

    /**
    * get ecash services
    */
    public function get_ecash_providers()
    {
        $params = array(
            'post_url'  => $this->post_urls['ecash'],
            'action'    => 'http://ecpay.ph/WKECash/GetServices'
        );
        $body   = '<GetServices xmlns="http://ecpay.ph/WKECash">' .
                    $this->default_body_params() .
                  '</GetServices>';

        $response = $this->request($params, $body);

        if (isset($response->GetServicesResponse)) {
            $items    = json_decode(json_encode($response->GetServicesResponse->GetServicesResult), true);

            if (isset($items[0])) {
                $data = json_decode($items[0], true);
                if (isset($data['Description'])) {
                    logger('[get_ecash_providers] : ' . $data['Description']);
                } else {
                    return $data;
                }
            } else {
                logger('[get_ecash_providers] : Invalid response.');
            }

        } else {
            logger('[get_ecash_providers] : Cannot connect to host.');
        }

        // print_data($response);
    }

    public function ecash_transact($fields = array()) 
    {
        $params = array(
            'post_url'  => $this->post_urls['ecash'],
            'action'    => 'http://ecpay.ph/WKECash/Transact'
        );

        $other_fields = '';
        foreach ($fields as $k => $v) {
            $other_fields .= "<{$k}>{$v}</$k>\n";
        }

        $this->ci->load->library('encryption');
        $this->ci->encryption->initialize(
            array(
                'driver' => 'openssl',
                'cipher' => 'tripledes'
            )
        );

        $sig = $this->ci->encryption->encrypt($this->branch_id . $this->username . $this->password);

        $header = '<AuthHeader xmlns="http://ecpay.ph/WKECash">
                        <signature>'. $sig .'</signature>
                        <secretkey>'. substr(md5(date('Ymd')), 0, 12) .'</secretkey>
                    </AuthHeader>';

        $body   = '<Transact xmlns="http://ecpay.ph/WKECash">' .
                    '<AccntID>' . $this->account_id . '</AccntID>
                    <Username>' . $this->username . '</Username>
                    <Password>' . $this->password . '</Password>
                    <BranchID>' . $this->branch_id . '</BranchID>' .
                    $other_fields .
                  '</Transact>';

        $response = $this->request($params, $body, $header);

        if (isset($response->TransactResponse)) {
            $items = json_decode(json_encode($response->TransactResponse->TransactResult), true);
            return (isset($items[0]) ? json_decode($items[0], true) : false);
        } else {
            logger('[ecash_transact] : Cannot connect to host.');
        }

        return false;
    }

    // END ECASH


    /**
    * get telco topup
    */
    public function get_telco_topups()
    {
        $params = array(
            'post_url'  => $this->post_urls['telco'],
            'action'    => 'http://ECPay/WSTopUp/GetTelcoList'
        );
        $body   = '<GetTelcoList xmlns="http://ECPay/WSTopUp">' .
                    '<LoginInfo>' .
                    $this->default_body_params(true) .
                    '</LoginInfo>' .
                  '</GetTelcoList>';

        $response = $this->request($params, $body);

        if (isset($response->GetTelcoListResponse)) {
            $items    = json_decode(json_encode($response->GetTelcoListResponse->GetTelcoListResult), true);

            if (isset($items['TStruct'][0]['TelcoName'])) {

                $records = array();
                foreach ($items['TStruct'] as $item) {
                    $records[] = $item;
                }

                return $records;

            } else {
                logger('[get_telco_topups] : ' . ($items['TStruct']['TelcoName'] ?? 'Error'));
            }

        } else {
            logger('[get_telco_topups] : Cannot connect to host.');
        }
    }

    public function telco_transact($fields = array()) 
    {
        $params = array(
            'post_url'  => $this->post_urls['telco'],
            'action'    => 'http://ECPay/WSTopUp/Transact'
        );

        $other_fields = '';
        foreach ($fields as $k => $v) {
            $other_fields .= "<{$k}>{$v}</$k>\n";
        }

        $body   = '<Transact xmlns="http://ECPay/WSTopUp">' .
                    '<LoginInfo>' .
                        $this->default_body_params(true) .
                    '</LoginInfo>' .
                    $other_fields .
                  '</Transact>';

        $response = $this->request($params, $body);

        if (isset($response->TransactResponse)) {
            return json_decode(json_encode($response->TransactResponse->TransactResult), true);
        } else {
            logger('[telco_transact] : Cannot connect to host.');
        }

        return false;
    }

    // END TELCO



    // ECLINK

    public function eclink_commit_payment($fields = array())
    {
        $params = array(
            'post_url'  => $this->post_urls['link'],
            'action'    => 'https://ecpay.ph/eclink/CommitPayment'
        );

        $other_fields = '';
        foreach ($fields as $k => $v) {
            $other_fields .= "<{$k}>{$v}</$k>\n";
        }

        $header = '<AuthHeader xmlns="https://ecpay.ph/eclink">
                        <merchantCode>'. $this->mc .'</merchantCode>
                        <merchantKey>'. $this->mk .'</merchantKey>
                    </AuthHeader>';

        $body   = '<CommitPayment xmlns="https://ecpay.ph/eclink">
                        '. $other_fields .'
                    </CommitPayment>';

        $response = $this->request($params, $body, $header);
        if (isset($response->CommitPaymentResponse)) {
            $returnData = json_decode($response->CommitPaymentResponse->CommitPaymentResult, true);
            if (isset($returnData[0]['resultCode']) && $returnData[0]['resultCode'] == 0) {
                return true;
            } else {
                logger('[eclink_commit_payment] : Failed transaction. (' . ($returnData[0]['resultCode'] ?? '-') .')');
            }
        } else {
            logger('[eclink_commit_payment] : Cannot connect to host.');
        }

        return false;
    }

    public function eclink_confirm_payment($fields = array())
    {
        $params = array(
            'post_url'  => $this->post_urls['link'],
            'action'    => 'https://ecpay.ph/eclink/ConfirmPayment'
        );

        $other_fields = '';
        foreach ($fields as $k => $v) {
            $other_fields .= "<{$k}>{$v}</$k>\n";
        }

        $header = '<AuthHeader xmlns="https://ecpay.ph/eclink">
                        <merchantCode>'. $this->mc .'</merchantCode>
                        <merchantKey>'. $this->mk .'</merchantKey>
                    </AuthHeader>';

        $body   = '<ConfirmPayment xmlns="https://ecpay.ph/eclink">
                        '. $other_fields .'
                    </ConfirmPayment>';

        $response = $this->request($params, $body, $header);
        if (isset($response->ConfirmPaymentResponse)) {
            $returnData = json_decode($response->ConfirmPaymentResponse->ConfirmPaymentResult, true);
            logger('[eclink_confirm_payment] : Response:' . ($returnData[0]['result'] ?? '-'));
            if (isset($returnData[0]['resultCode']) && $returnData[0]['resultCode'] == 0) {
                return json_decode($returnData[0]['result'], true)[0] ?? false; // return full data
            }
        } else {
            logger('[eclink_confirm_payment] : Cannot connect to host.');
        }

        return false;
    }

    public function fetch_eclink_payments($data)
    {
        $params = array(
            'post_url'  => $this->post_urls['link'],
            'action'    => 'http://ECPay/WSTopUp/Transact'
        );

        $date = date('m-d-Y', strtotime($data['date']));

        $header = '<AuthHeader xmlns="https://ecpay.ph/eclink">
                        <merchantCode>'. $this->mc .'</merchantCode>
                        <merchantKey>'. $this->mk .'</merchantKey>
                    </AuthHeader>';

        $body   = '<FetchPayments xmlns="https://ecpay.ph/eclink">
                        <strdate>'. $date .'</strdate>
                    </FetchPayments>';

        $response = $this->request($params, $body, $header);

        print_r($response);
        // if (isset($response->TransactResponse)) {
        //     return json_decode(json_encode($response->TransactResponse->TransactResult), true);
        // } else {
        //     logger('[telco_transact] : Cannot connect to host.');
        // }

        return false;
    }

    // END ECLINK


    // CHECK BALANCE

    public function ecpay_check_balance($fields = array())
    {
        $params = array(
            'post_url'  => $this->post_urls['bills'],
            'action'    => 'http://tempuri.org/ECPNBillsPayment/Service1/CheckBalance'
        );

        $body   = '<CheckBalance xmlns="http://tempuri.org/ECPNBillsPayment/Service1">' .
                    $this->default_body_params() .
                  '</CheckBalance>';

        $response = $this->request($params, $body);

        if (isset($response->CheckBalanceResponse)) {
            $items    = json_decode(json_encode($response->CheckBalanceResponse->CheckBalanceResult), true);
            if (isset($items['RemBal']) && is_numeric($items['RemBal'])) {
                return $items['RemBal'];
            } else {
                logger('[ecpay_check_balance] : Invalid response. -> ' . json_encode($items));
            }
        } else {
            logger('[ecpay_check_balance] : Cannot connect to host.');
        }

        return false;
    }

    public function gate_check_balance($fields = array())
    {
        $params = array(
            'post_url'  => $this->post_urls['telco'],
            'action'    => 'http://ECPay/WSTopUp/CheckBalance'
        );

        $body   = '<CheckBalance xmlns="http://ECPay/WSTopUp">' .
                    '<LoginInfo>' .
                        $this->default_body_params(true) .
                    '</LoginInfo>' .
                  '</CheckBalance>';

        $response = $this->request($params, $body);

        if (isset($response->CheckBalanceResponse)) {
            $items    = json_decode(json_encode($response->CheckBalanceResponse->CheckBalanceResult), true);
            if (isset($items['RemBal']) && is_numeric($items['RemBal'])) {
                return $items['RemBal'];
            } else {
                logger('[gate_check_balance] : Invalid response. -> ' . json_encode($items));
            }
        } else {
            logger('[gate_check_balance] : Cannot connect to host.');
        }

        return false;
    }

    // END CHECK BALANCE


    private function default_body_params($branch = false)
    {
        $str = '<AccountID>' . $this->account_id . '</AccountID>
                <Username>' . $this->username . '</Username>
                <Password>' . $this->password . '</Password>';

        if ($branch) {
            $str .= '<BranchID>'. $this->branch_id .'</BranchID>';
        }

        return $str;
    }

    /**
    *
    * @param $params[post_url, host, action]
    */
    private function request($params, $body, $header = false)
    {

        if (!isset($params['post_url']) || !isset($params['action'])) {
            die('Invalid soap request params');
        }

        if (isset($_GET['jimtest']) && $_GET['jimtest'] == '1') {
            $this->debug = true;
        }

        $soapUrl      = $params['post_url'];
        $soapAction   = $params['action'];
        $soapHost     = (isset($params['host']) ? $params['host'] : $this->default_host);
        $soap_header  = '';

        if ($header) {
            $soap_header = '<soap:Header>' . $header . '</soap:Header>';
        }
        
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                                xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                                    '. $soap_header .'
                                    <soap:Body>
                                        ' . $body . '
                                    </soap:Body>
                                </soap:Envelope>';

        $headers = array(
            "Host: " . $soapHost,
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: " . $soapAction, 
            "Content-length: ". strlen($xml_post_string),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $soapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting
        $response = curl_exec($ch); 
        curl_close($ch);

        if ($this->debug) {
            echo 'URL: ' . $soapUrl . PHP_EOL;
            echo PHP_EOL;
            echo '<pre>';
            print_r($headers);
            echo PHP_EOL;
            echo PHP_EOL;
            echo htmlentities($xml_post_string) . PHP_EOL;
            echo '</pre>';
            var_dump($response) . PHP_EOL;
        }

        logger("[$soapAction] Response:  $response.");

        // // converting
        $response1 = str_replace("<soap:Body>","",$response);
        $response2 = str_replace("</soap:Body>","",$response1);

        // // convertingc to XML
        return @simplexml_load_string($response2);
    }

}

/* End of file ECPay.php */
/* Location: ./application/libraries/ECPay.php */
