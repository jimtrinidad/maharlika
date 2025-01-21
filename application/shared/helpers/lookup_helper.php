<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function lookup($collection, $id = null)
{

	$ci = &get_instance();

	$items = $ci->config->item($collection);

    if ($items == null) {
        // get item from database
        $items = array();
        $table = 'Lookup_' . $collection;
        if ($ci->db->table_exists($table)) {

            $ci->db->where('Status', 1);
            $ci->db->order_by('Ordering');
            $results = $ci->db->get($table)->result();
            foreach ($results as $result) {
                $items[$result->id] = $result->Value;
            }

        }
    }
	
	if ($id !== null) {

        if (is_array($id)) {
            $match = array();
            foreach ($id as $i) {
                if (isset($items[$i])) {
                    $match[] = $items[$i];
                }
            }
            return $match;
        } else if (isset($items[$id])) {
            return $items[$id];
        }

        return false;
    } else {
        return $items;
    }

}

function lookup_db($tableName, $fieldName, $id = null, $formatted = true, $options = array())
{

    $ci = &get_instance();

    if ($id != null) {
        $ci->db->where('id', $id);
        $q = $ci->db->get($tableName);
        if ($q->num_rows() > 0) {
            return $q->row()->{$fieldName};
        }
        return false;
    }

    if (is_array($options)) {
        foreach ($options as $k => $v) {
            if (is_array($v)) {
                $ins = $ci->db;
                @call_user_func_array(array($ins, $k), $v);
            } else {
                @$ci->db->{$order_by}($v);
            }
        }
    }

    $results = $ci->db->get($tableName)->result_array();
    if ($formatted === false) {
        return $results;
    }

    $items = array();
    foreach ($results as $result) {
        $items[$result['id']] = $result[$fieldName];
    }

    return $items;
}


function lookup_all($tableName, $where = false, $order = false, $exclude_deleted = true)
{
    $ci = &get_instance();
    if ($where !== false) {
        $ci->db->where($where);
    }

    if ($exclude_deleted === true) {
        $ci->db->where('deletedAt', NULL);
    }

    if ($order !== false) {
        $ci->db->order_by($order);
    }

    return $ci->db->get($tableName)->result_array();
}

/**
 * return single row object
 * use getRowObject from appdb model
 */
function lookup_row($tableName, $find, $field = 'id', $select = false)
{
    $ci = &get_instance();
    $record = $ci->appdb->getRowObject($tableName, $find, $field);
    if (is_array($select) && $record) {
        $clean = array();
        foreach ($record as $key => $value) {
            if (in_array($key, $select)) {
                $clean[$key] = $value;
            }
        }
        return (object) $clean;
    } 
    return $record;

}


function lookup_address($codes)
{
    $address = array(
        'Province'  => '',
        'MuniCity'  => '',
        'Barangay'  => ''
    );

    $codes = (array) $codes;

    if (isset($codes['Province']) && $codes['Province']) {
        $tableData = lookup_row('UtilLocProvince', $codes['Province'], 'provCode');
        if ($tableData) {
            $address['Province'] = $tableData->provDesc;
        }
    }

    if (isset($codes['City']) && $codes['City']) {
        $tableData = lookup_row('UtilLocCityMun', $codes['City'], 'citymunCode');
        if ($tableData) {
            $address['MuniCity'] = $tableData->citymunDesc;
        }
    }

    if (isset($codes['Barangay']) && $codes['Barangay']) {
        $tableData = lookup_row('UtilLocBrgy', $codes['Barangay'], 'brgyCode');
        if ($tableData) {
            $address['Barangay'] = $tableData->brgyDesc;
        }
    }

    return $address;
}
