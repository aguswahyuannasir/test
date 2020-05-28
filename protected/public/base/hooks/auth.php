<?php

// function get_user() {
//     $CI = & get_instance();
//     if ($CI->uri->segment(1) != 'ajax') {
//         if ($CI->aauth->is_loggedin()) {
//             if ($CI->router->fetch_class() == 'auth') {
//                 redirect('');
//             }
//             if (!$CI->session->has_userdata('user')) {
//                 $user = $CI->aauth->get_user();
//                 $CI->session->set_userdata('user', $user);
//             }
//             $CI->data['user'] = $CI->session->userdata('user');
//         } else {
//             if (!in_array($CI->router->fetch_class(), ['auth'])) {
//                 redirect('auth/login?back=' . uri_string());
//             }
//         }
//     }
// }
