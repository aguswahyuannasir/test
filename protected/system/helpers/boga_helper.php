<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

if (!function_exists('encode')) {

    function encode($string) {
        return encrypt_decrypt('encrypt', $string);
    }

}

if (!function_exists('decode')) {

    function decode($string) {
        return encrypt_decrypt('decrypt', $string);
    }

}

if (!function_exists('encrypt_decrypt')) {

    function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'BogaSoftware';
        $secret_iv = 'Boga Software';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}

if (!function_exists('number')) {

    function number($val) {
        $value = number_format($val, settings('number_of_decimal'), settings('separator_decimal'), settings('separator_thousand'));
        return $value;
    }

}

if (!function_exists('parse_number')) {

    function parse_number($number) {
        $dec_point = settings('number_separator_decimal');
        if (empty($dec_point)) {
            $locale = localeconv();
            $dec_point = $locale['decimal_point'];
        }
        return floatval(str_replace($dec_point, '.', preg_replace('/[^\d' . preg_quote($dec_point) . ']/', '', $number)));
    }

}

if (!function_exists('money')) {

    function money($amount, $currency = 0) {
        $CI = get_instance();
        $CI->load->database();
        $currency = $CI->db->get_where('currencies', ['id' => ($currency ? $currency : settings('default_currency'))]);
        if ($currency->num_rows()) {
            $currency = $currency->row();
            $amount = money_formating($amount, $currency->prefix, $currency->decimal_digit, $currency->decimal_separator, $currency->thousand_separator, $currency->suffix);
        }
        return $amount;
    }

}
if (!function_exists('money_formating')) {

    function money_formating($amount, $prefix, $decimal_digit, $decimal_separator, $thousand_separator, $suffix, $isPrefMinus = false) {
        if ($isPrefMinus == true) {
            if ($amount < 0) {
                $amount = str_replace("-","", $amount);
                return "- (".$prefix.number_format($amount, $decimal_digit, $decimal_separator, $thousand_separator) . $suffix.")";
            }else{
                return $prefix . number_format($amount, $decimal_digit, $decimal_separator, $thousand_separator) . $suffix;
            }
        }else{
            return $prefix . number_format($amount, $decimal_digit, $decimal_separator, $thousand_separator) . $suffix;
        }
    }

}

if (!function_exists('get_date')) {

    function get_date($date = '') {
        if ($date) {
            $CI = get_instance();
            $format = $CI->data['org']->format_date;
            $timestamp = strtotime($date);
            return date($format, $timestamp);
        }
    }

}

if (!function_exists('get_date_mysql')) {

    function get_date_mysql($date) {
        return date_format(date_create_from_format(settings('date_format'), $date), 'Y-m-d');
    }

}

if (!function_exists('get_date_time')) {

    function get_date_time($date = '') {
        if ($date) {
            $format = settings('date_format') . ' H:i';
            $timestamp = strtotime($date);
            return date($format, $timestamp);
        }
        return false;
    }

}

if (!function_exists('get_month')) {

    function get_month($month) {
        $CI = get_instance();
        if (is_numeric($month)) {
            $month = date('F', strtotime('2017-' . $month . '-01 00:00:00'));
        }
        return $CI->lang->line($month);
    }

}

if (!function_exists('month_name')) {

    function month_name($month) {
        $CI = get_instance();
        if (is_numeric($month)) {
            $month = date('F', strtotime('2017-' . $month . '-01 00:00:00'));
        }
        return $CI->lang->line($month);
    }

}
if (!function_exists('month_name_abbr')) {

    function month_name_abbr($month) {
        $CI = get_instance();
        if (is_numeric($month)) {
            $month = date('M', strtotime('2017-' . $month . '-01 00:00:00'));
        }
        return $CI->lang->line($month);
    }

}

if (!function_exists('day_name')) {

    function day_name($date) {
        $CI = get_instance();
        $day = date('D', strtotime($date));
//        return $CI->lang->line($day);
        return $day;
    }

}

if (!function_exists('get_image')) {

    function get_image($image) {
        $image = base_url($image);
        $file_headers = @get_headers($image);
        if ($file_headers[0] == 'HTTP/1.0 404 Not Found') {
            return false;
        } else if ($file_headers[0] == 'HTTP/1.0 302 Found' && $file_headers[7] == 'HTTP/1.0 404 Not Found') {
            return false;
        } else {
            return $image;
        }
    }

}

if (!function_exists('settings')) {

    function settings($key) {
        if ($key) {
            $CI = get_instance();
            if ($CI->session->has_userdata('kabulkanSettings')) {
                return $CI->session->userdata('kabulkanSettings')[$key];
            } else {
                $CI->load->database();
                $settings = $CI->db->get('settings');
                foreach ($settings->result() as $setting) {
                    $data[$setting->key] = $setting->value;
                }
                $CI->session->set_userdata('kabulkanSettings', $data);
                return $data[$key];
            }
        } else {
            return false;
        }
    }

}

if (!function_exists('send_mail')) {

    function send_mail($from, $from_name, $to, $subject, $message) {
        $CI = get_instance();
//        $CI->config->load('smtp');
        $CI->load->library('email');
        $CI->email->initialize(array(
            'protocol' => 'smtp',
            'smtp_host' => settings('smtp_host'),
            'smtp_user' => settings('smtp_user'),
            'smtp_pass' => settings('smtp_password'),
            'smtp_port' => settings('smtp_port'),
            'smtp_crypto' => settings('smtp_crypto'),
            'crlf' => "\r\n",
            'newline' => "\r\n",
            'mailtype' => 'html'
        ));
        $CI->email->from($from, $from_name);
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);

        if ($CI->email->send())
            return true;
        else {
            log_message('error', $CI->email->print_debugger());
            return false;
        }
    }

}

if (!function_exists('get_payment_method')) {
    function get_payment_method(){
        $CI = get_instance();

        $data = $CI->db->select("*")
            ->from("payment_methods")
            ->where("status", 1)
            ->order_by("sort_order")
            ->get()->result();
        return $data;
    }
}

if (!function_exists('get_master_account')) {
    function get_master_account(){
        $CI = get_instance();

        $data = $CI->db->select("*")
            ->from("master_account")
            ->where("status", 1)
            ->order_by('acc_name','asc')
            ->get()->result();
        return $data;
    }
}
/* End of file common_helper.php */
/* Location: ./system/helpers/common_helper.php */
