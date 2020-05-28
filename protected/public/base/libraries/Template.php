<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

class Template
{

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function _init($template = 'default')
    {
        $this->ci->output->set_template($template);

        $this->ci->load->css('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900');
        $this->ci->load->css(base_url('assets/css/bootstrap.css'));
        $this->ci->load->css(base_url('assets/css/bootstrap_limitless.min.css'));

        $this->ci->load->js(base_url('assets/js/core/libraries/jquery.min.js'));
    }
}
