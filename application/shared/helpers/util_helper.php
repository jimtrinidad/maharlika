<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function microsecID($random_time = false) {
    if ($random_time) {
        return mt_rand(1000000000, time()) . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
    } else {
	   $v = round(microtime(true) * 1000);
    }
    // just returning $v as floats converts to exponential value
    return number_format($v, 0, '', '');
}

function generate_public_id($lastname, $suffix_length = 4)
{
    // remove all except letters
    $clean  = preg_replace("/[^A-Za-z]/", '', $lastname);
    $name   = strtoupper($clean);

    $randomNumber = random_number($suffix_length);

    $id = $name . $randomNumber;

    // check if not exists
    $ci =& get_instance();
    $query = $ci->db->where('PublicID', $id)->get('Users');
    if ($query->num_rows() > 0) {
        // retry if exists
        $id = generate_public_id($lastname);
    }

    return $id;
}

function datetime() {
    return date('Y-m-d H:i:s');
}

function current_controller()
{
    $ci =& get_instance();
    return $ci->router->fetch_class();
}

function current_method()
{
    $ci =& get_instance();
    return $ci->router->fetch_method();
}

function is_current_url($controller, $method = false)
{
    if (current_controller() != $controller) {
        return false;
    }

    if ($method && current_method() != $method) {
        return false;
    }

    return true;
}

function recache() {
    return time();
    // return strtotime(date('Y-m-d', time()));
}


function random_number($length)
{
    return join('', array_map(function($value) { return mt_rand(0, 9); }, range(1, $length)));
}


function random_password($length = 8) 
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $password = array(); 
    $alpha_length = strlen($alphabet) - 1; 
    for ($i = 0; $i < $length; $i++) 
    {
        $n = rand(0, $alpha_length);
        $password[] = $alphabet[$n];
    }
    return implode($password); 
}

function random_letters($length = 8) 
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $letters  = array(); 
    $alpha_length = strlen($alphabet) - 1; 
    for ($i = 0; $i < $length; $i++) 
    {
        $n = rand(0, $alpha_length);
        $letters[] = $alphabet[$n];
    }
    return implode($letters); 
}


function account_public_id()
{
    if (current_user()) {
        return '09' . str_pad(current_user(), 4, '0', STR_PAD_LEFT);
    }
    return false;
}

/**
* get qr file
* generate new if not exists
*/
function get_qr_file($data, $size = 3)
{
    $extension  = 'png';
    $key        = md5($data);
    $filename   = $key . '.' . $extension;
    $qr_path    = PUBLIC_DIRECTORY . 'assets/qr/' . $filename;
    if (file_exists($qr_path)) {
        return $filename;
    } else {
        // generate new
        $ci =& get_instance();
        $ci->load->library('qr/ciqrcode', array(
            'cachedir'  => APPPATH . 'cache/',
            'errorlog'  => APPPATH . 'logs/'
        ));

        $qrparams['data']   = $data;
        $qrparams['level']  = 'H';
        $qrparams['size']   = $size;
        $qrparams['black']  = array(13, 54, 17);
        $qrparams['savename'] = $qr_path;
        $ci->ciqrcode->generate($qrparams);
        if (file_exists($qr_path)) {
            return $filename;
        }
    }
    return false;
}

/**
* image to data uri
*/
function getDataURI($image, $mime = '') {
    return 'data: '.(function_exists('mime_content_type') ? mime_content_type($image) : $mime).';base64,'.base64_encode(file_get_contents($image));
}

/**
* quick print r with pre and exit;
*/
function print_data($data, $exit = false)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($exit) {
        exit;
    }
}


/**
* time ago
* get time difference
*/
function time_ago($from, $until = 'now', $format = 'string')
{
    $date = new DateTime($from);
    $interval = $date->diff(new DateTime($until));

    $diff = array(
            'y' => $interval->y,
            'm' => $interval->m,
            'd' => $interval->d,
            'h' => $interval->h,
            'i' => $interval->i,
            's' => $interval->s,
        );

    if ($format == 'array') {
        return $diff;
    } else {
        $str = '';
        if ($diff['y']) {
            $str .= '%yy, ';
        }
        if ($diff['m']) {
            $str .= '%mm, ';
        }
        if ($diff['d']) {
            $str .= '%dd, ';
        }
        if ($diff['h']) {
            $str .= '%hh, ';
        }
        $str .= '%imin';

        return $interval->format($str);
    }
}


/**
* number to words
*/
function number_to_words($number)
{
    $f = new NumberFormatter("en_US", NumberFormatter::SPELLOUT);
    $f->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
    return $f->format($number);
}

function peso($number, $showSign = true, $decimal = 2)
{
    return ($showSign ? '₱' : '') . rtrim(rtrim(number_format($number, $decimal, ".", ","), '0'), '.');
}

function show_price($srp, $discount)
{
    if ($discount > 0) {
        $discounted_price = $srp - $discount;
        $percent = round(($discount / $srp) * 100, 2);
        // return $percent . ' - ' . $srp . ' - ' . $discount . ' - ' . $discounted_price;
        return peso($discounted_price) . 
                '<small class="">
                    <span class="original_price">' . peso($srp) . '</span> 
                    <span class="discount_percent">-'. $percent .'%</span>
                </small>';
    } else {
        return peso($srp);
    }
}


function csrf_token_input_field()
{
    $ci =& get_instance();
    return '<input type="hidden" name="' . $ci->security->get_csrf_token_name() . '" value="' . $ci->security->get_csrf_hash() . '">';
}



/**
* commision distribution
* @param item price
* @param commision value (percent or actual profit)
* @param commision type (1 - transaction fee, 2 - commision percent)
*
* type 1 - commission is the profit
* type 2 - get profit first (refer to excel for compuration)
*/
function profit_distribution($srp, $commision, $type, $distribution_only = false)
{
    $discount         = 0;
    $discount_rate    = 0;
    $supplier_price   = $srp;
    $discounted_price = $srp;

    if ($type == 1) {
        $profit = $commision;
    } else {
        // get profit
        if ($commision > 0) { 
            $supplier_price     = $srp - ($srp * ($commision/100));
        }
        $discount_rate      = partner_commision_rate($commision);
        $discount           = ($discount_rate > 0 ? ($srp * ($discount_rate/100)) : 0);
        $discounted_price   = $srp - $discount;
        $profit             = $discounted_price - $supplier_price;
    }

    $data = array(
        'srp'            => $srp,
        'commision'      => $commision,
        'commision_type' => $type,
        'supplier_price' => $supplier_price,
        'discounted_price' => $discounted_price,
        'discount_rate'  => $discount_rate,
        'discount'       => $discount
    );

    $profit_dist        = array(
        'profit'         => $profit,
        'company'        => $profit * 0.30,
        'investor'       => $profit * 0.10,
        'referral'       => $profit * 0.25,
        'delivery'       => $profit * 0.25,
        'cashback'       => $profit * 0.02,
        'shared_rewards' => $profit * 0.08,
    );

    $profit_dist['divided_reward'] = ($profit_dist['shared_rewards'] > 0 ? ($profit_dist['shared_rewards'] / 8) : 0);

    if ($distribution_only) {
        return $profit_dist;
    }

    return array_merge($data, $profit_dist);
}

/**
* return the exact commision percent
*/
function partner_commision_rate($c)
{
    if ($c >= 3 && $c <= 8) {
        return 1;
    } else if ($c >= 9 && $c <= 17) {
        return 3;
    } else if ($c >= 18 && $c <= 26) {
        return 6;
    } else if ($c >= 27 && $c <= 35) {
        return 9;
    } else if ($c >= 36 && $c <= 44) {
        return 12;
    } else if ($c >= 45 && $c <= 53) {
        return 15;
    } else if ($c >= 54 && $c <= 62) {
        return 18;
    } else if ($c >= 63 && $c <= 71) {
        return 21;
    } else if ($c >= 72 && $c <= 80) {
        return 24;
    } else if ($c >= 81 && $c <= 100) {
        return 27;
    }

    return 0;
}

function ec_profit_distribution($profit)
{
    $profit_dist        = array(
        'profit'         => $profit,
        'company'        => $profit * 0.25,
        'investor'       => $profit * 0.25,
        'referral'       => $profit * 0.40,
        'cashback'       => $profit * 0.02,
        'shared_rewards' => $profit * 0.08,
    );

    $profit_dist['divided_reward'] = ($profit_dist['shared_rewards'] > 0 ? ($profit_dist['shared_rewards'] / 8) : 0);

    return $profit_dist;
}


function logger($message)
{
    syslog(LOG_INFO, '[AMBILIS] ' . $message);
}

function clean_text($string)
{   
    // remove parentheses
    $string = preg_replace("/\([^)]+\)/","",$string);
    // trim
    $string = trim($string);

    return $string;
}


function slugit($str, $replace=array(), $delimiter='-')
{
    $str = trim($str);
    if ( !empty($replace) ) {
        $str = str_replace((array)$replace, ' ', $str);
    }
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    return $clean;
}