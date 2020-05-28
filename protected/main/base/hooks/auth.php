<?php

function get_user() {
    $CI = & get_instance();
    if ($CI->aauth->is_loggedin()) {
        if (uri_string() == 'auth/login') {
            redirect('');
        }
        if (!$CI->session->has_userdata('user')) {
            $user = $CI->aauth->get_user();
            $CI->session->set_userdata('user', $user);
        }
        $CI->data['user'] = $CI->session->userdata('user');
    } else {
        if (!in_array($CI->router->fetch_class(), ['auth']) && !in_array($CI->uri->segment(1), ['crons','api', 'validationemail'])) {
            redirect('auth/login?back=' . uri_string());
        }
    }
}

function redirect_https() {
    $CI = & get_instance();
    $class = $CI->router->fetch_class();
    $exclude = [];  // add more controller name to exclude ssl.
    if (!in_array($class, $exclude)) {
        // redirecting to ssl.
        $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
        if ($_SERVER['SERVER_PORT'] != 443)
            redirect($CI->uri->uri_string());
    }
    else {
        // redirecting with no ssl.
        $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
        if ($_SERVER['SERVER_PORT'] == 443)
            redirect($CI->uri->uri_string());
    }
}
