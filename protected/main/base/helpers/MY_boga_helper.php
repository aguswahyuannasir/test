<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

function menu_active($active, $is_submenu = TRUE) {
    $CI = get_instance();
    if (substr($CI->data['menu'], 0, strlen($active)) == $active) {
        return $is_submenu ? 'nav-item-expanded nav-item-open' : 'current';
    } else {
        return FALSE;
    }
}
function order_code() {
    $CI = get_instance();
    $CI->load->database();
    $query = $CI->db->select('MAX(SUBSTR(code, 14)) code')
            ->where('YEAR(date_added)', date('Y'))
            ->where('MONTH(date_added)', date('m'))
            ->get('orders');
    if ($query->num_rows() > 0) {
        $increment = $query->row()->code;
    } else {
        $increment = 0;
    }
    $increment = ($increment == 0) ? 1 : $increment + 1;
    if ($increment < 10) {
        $increment = '000' . $increment;
    } elseif ($increment < 100) {
        $increment = '00' . $increment;
    } elseif ($increment < 1000) {
        $increment = '0' . $increment;
    }
    $code = 'ORDER/' . date('Ym') . '/' . $increment;
    return $code;
}

if (!function_exists('check_url')) {

    function check_url($keyword, $query = '') {
        $CI = get_instance();
        $CI->load->database();

        if ($query)
            $CI->db->where('query !=', $query);
        $query = $CI->db->where('keyword', $keyword)->get('seo_url');
        return($query->num_rows() > 0) ? true : false;
    }

}

if (!function_exists('remove_space')) {

    function remove_space($string) {
        return str_replace(' ', '', $string);
    }

}

if (!function_exists('rupiah')) {

    function rupiah($angka){
        $hasil_rupiah = number_format($angka,0,',','.');
        return 'Rp.'.$hasil_rupiah;
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

function optionYear(){
    $currentYear = date("Y");
    $minYear     = 2019;
    $result      = "";
    for ($i=$currentYear; $i >= $minYear ; $i--) { 
        $result.="<option value='$i'>".$i."</option>";
    }
    return $result;
}

function optionMonth(){
    $currentMonth = date("m");
    $result       = "";
    for ($i=1; $i <=12 ; $i++) { 
        $selected = "";
        if ($i == $currentMonth) {
            $selected = "selected";
        }
        // Generate Month Name By Number
        $dateObj   = DateTime::createFromFormat('!m', $i);
        $monthName = $dateObj->format('F');

        $result.="<option value='$i' $selected>".$monthName."</option>";
    }
    return $result;
}

function salesStatusLabel($status = ""){
    if ($status == "open") {
        $return = '<span class="label label-primary">'.strtoupper($status).'</span>';
    }elseif($status == "paid"){
        $return = '<span class="label label-success">'.strtoupper($status).'</span>';
    }elseif($status == "draft"){
        $return = '<span class="label label-default">'.strtoupper($status).'</span>';;
    }elseif($status == ""){
        $return = '<span class="label label-danger">UNDEFINED</span>';
    }else{
        $return = '<span class="label label-danger">'.strtoupper($status).'</span>';
    }
    return $return;
}

function ifStringEmptyDefault($parameter = "", $echos = "-"){
    if ($parameter == "") {
        return $echos;
    }else{
        return $parameter;
    }
}

function checkVersion(){
    $CI = get_instance();

    // My Database
    $CI->db->select('value');
    $CI->db->from('settings');
    $CI->db->where('key', 'app_version');
    $CI->db->or_where('key', 'server_env');
    $query2 = $CI->db->get();
    $result = $query2->result();

    $env = "production";
    if (count($result) > 1) {
        $env = $result[1]->value;
    }


    $url_check = DEV_URL."api/check_version";
    $get_check = curl_function($url_check);
    if (empty($get_check)) {
        $app_remote_version = "0.0";
    }else{
        $get_check = str_replace("\ufeff","", json_encode($get_check));
        $decode    = json_decode(json_decode($get_check, true), true);

        $app_remote_version = $decode['data']['version'];
    }

    $app_remote_version = $app_remote_version;
    $app_my_version     = $query2->row()->value;

    $data['my_version']     = $app_my_version;
    $data['remote_version'] = $app_remote_version;
    $data['server_env']     = $env;
    return $data;
}

function curl_function($url, $method = "GET"){
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL            => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING       => "",
      CURLOPT_CUSTOMREQUEST  => $method,
      CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Connection: keep-alive",
            "Content-type: multipart/form-data"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function dev_version($number = 0.0){
    $expl_number = explode(".", $number);
    $get_number  = end($expl_number);
    return $get_number;
}
/* End of file common_helper.php */
/* Location: ./system/helpers/common_helper.php */
