<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

function menu_active($active, $is_submenu = TRUE) {
    $CI = get_instance();
    if (substr($CI->data['menu'], 0, strlen($active)) == $active) {
        return $is_submenu ? 'nav-item-expanded nav-item-open' : 'active';
    } else {
        return FALSE;
    }
}

if (!function_exists('remove_space')) {

    function remove_space($string) {
        return str_replace(' ', '', $string);
    }

}

if (!function_exists('create_code')) {

    function create_code($type) {
        $CI = get_instance();
        $CI->load->database();
//        $format = settings('code_format_' . $type);
        $format = 'format_' . $type;
        $format = $CI->data['org']->{$format};
        if ($type == 'sale_invoice') {
            $table = 'sales';
            $CI->db->where('type', 'invoice');
        } elseif ($type == 'sale_quote') {
            $table = 'sales';
            $CI->db->where('type', 'quote');
        }elseif ($type == 'purchase_invoice') {
            $table = 'purchases';
            $CI->db->where('type', 'invoice');
        } elseif ($type == 'purchase_quote') {
            $table = 'purchases';
            $CI->db->where('type', 'quote');
        }
        $in = $CI->db->where('organization', $CI->data['org']->id)->where('YEAR(date)', date('Y'))->count_all_results($table);
        $in = ($in == 0) ? 1 : $in + 1;
        if ($in < 10) {
            $in = '0000' . $in;
        } elseif ($in < 100) {
            $in = '000' . $in;
        } elseif ($in < 1000) {
            $in = '00' . $in;
        } elseif ($in < 10000) {
            $in = '0' . $in;
        }
        $code = str_replace('[NUM]', $in, $format);
        $code = str_replace('[MM]', date('m'), $code);
        $code = str_replace('[YY]', date('y'), $code);
        $code = str_replace('[YYYY]', date('Y'), $code);
        return $code;
    }

}

function aauth_log($message, $module = NULL, $module_id = NULL, $object = NULL, $object_id = NULL, $data = []) {
    $CI = get_instance();
    $log_data = [
        'user' => $CI->session->userdata('id'),
        'message' => $message,
        'module' => $module,
        'module_id' => $module_id,
        'object' => $object,
        'object_id' => $object_id,
        'data' => json_encode($data),
    ];

    if (!$CI->session->has_userdata('last_log')) { //jika belum ada sesi last log
        //set las log
        $CI->session->set_userdata('last_log', json_encode($log_data));
    }

    $last_log_data = json_decode($CI->session->userdata('last_log'));

    if ($last_log_data->object != $log_data['object'] || $last_log_data->object_id != $log_data['object_id'] || $last_log_data->module != $log_data['module'] || $last_log_data->module_id != $log_data['module_id'] || $last_log_data->data != $log_data['data']) {
        $CI->session->set_userdata('last_log', json_encode($log_data));
        $CI->load->database();
        $CI->db->insert('aauth_log', $log_data);
    }
}

function debugCode($param = array()){
    echo "<pre>";
    print_r($param);
    echo "</pre>";
    die();
}
/* End of file common_helper.php */
/* Location: ./system/helpers/common_helper.php */
