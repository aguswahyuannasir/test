<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->aauth->control('setting/user');

        $this->lang->load('users', settings('language'));

        $this->data['menu'] = 'setting/user/list';
        $this->data['module_url'] = site_url('settings/users/');
        $this->table = 'aauth_users';
    }

    public function index2() {
      
        
    }
    public function change_password() {
      if ($this->input->post()) {
          $this->load->library('form_validation');
          $this->form_validation->set_rules('password', 'lang:password', 'trim|required');
          $this->form_validation->set_rules('password_conf', 'lang:password_conf', 'trim|required|matches[password]');
          if ($this->form_validation->run() == true) {
              $data = $this->input->post(null, true);
              $this->aauth->update_user($this->data['user']->id,FALSE,$data['password']);
              redirect();
          } else { 
            $this->data['error'] = true;
            $this->data['error_msg'] = validation_errors();
          }
      }
     
      $this->template->_init();
      $this->output->set_title(lang('change_pass'));
      $this->load->view('change_pass/form', $this->data);
  }

    


}
