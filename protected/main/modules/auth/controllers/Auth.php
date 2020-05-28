<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('auth', settings('language'));
    }

    public function login() {
        $this->data['page']  = 'login';
        $this->data['error'] = false;
        $this->config->load('aauth');
        
        /*$this->config->set_item('aauth',$this->config->item('aauth_admin'));
        $this->config->set_item('aauth_admin',$this->config->item('aauth_admin'));*/
        //$this->config->set_item('aauth',$this->config->item('aauth_admin'));
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('identity', 'lang:email', 'required');
            $this->form_validation->set_rules('password', 'lang:password', 'required');

            if ($this->form_validation->run() == true) {
                $remember = (bool) $this->input->post('remember');
                if ($this->aauth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                    $this->input->set_cookie('pyduid', encode($this->aauth->get_user_id()), 72000000);
                    redirect('/');
                } else {
                    $this->data['error'] = true;
                }
            } else {
                $this->data['error'] = true;
            }
        }
        $this->template->auth();
        $this->output->set_title('Login');
        $this->load->view('login', $this->data);
    }

    public function logout() {
        $this->aauth->logout();
        $this->load->helper('cookie');
        delete_cookie('pyduid');
        redirect('auth/login', 'refresh');
    }

    public function register() {
        $this->data['page'] = 'register';
        $this->data['error'] = false;
        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name', 'lang:name', 'trim|required');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|callback__check_email');
            $this->form_validation->set_rules('password', 'lang:password', 'trim|required|alpha_dash');
            $this->form_validation->set_rules('confpassword', 'lang:confirm_password', 'required|matches[password]');

            if ($this->form_validation->run() == true) {
                if ($register = $this->aauth->create_user($this->input->post('email'), $this->input->post('password'), FALSE, 'owner')) {
                    $this->main->update('members', ['fullname' => $this->input->post('name')], ['id' => $register]);
                    $this->data['success_message'] = lang('register_successfully');

                    // SEND EMAIL NOTIFICATION
                    $nama           = $this->input->post('name');
                    $from_email     = $this->input->post('email');
                    $today          = date ( "Y-m-d H:i:s" );
                    $subject_email  = "[$nama] – [$from_email] telah melakukan regitrasi pada [$today]";
                    $template       = $this->load->view("email_notif", $this->data, true);
                    $email_technical = "technical@omeoo.com";
                    $this->send_email("catatanengineer@gmail.com", "noreplay", "aguswahyuannasir@gmail.com", $from_email, $subject_email, $template);

                } else {
                    $this->data['error'] = true;
                    $this->data['error_message'] = $this->aauth->print_errors();
                }
            } else {
                $this->data['error'] = true;
                $this->data['error_message'] = validation_errors();
            }
        }
        $this->template->auth();
        $this->output->set_title('Register');
        $this->load->view('register', $this->data);
    }

    function _check_email() {
        if (!$this->aauth->user_exist_by_email($this->input->post('email')))
            return true;
        else {
            $this->form_validation->set_message('_check_email', lang('email_existing'));
            return false;
        }
    }

   /*public function forgot_password() {
       if ($this->aauth->logged_in())
           redirect();

       if ($this->input->is_ajax_request()) {
           $this->form_validation->set_rules('email', 'Alamat Email', 'required|valid_email');
           if ($this->form_validation->run() == true) {
               $forgotten = $this->aauth->forgotten_password($this->input->post('email'));
               if ($forgotten) {
                   $return = array('message' => 'Permintaan reset password telah diterima. Silahkan cek email Anda untuk langkah selanjutnya.', 'status' => 'success');
               } else {
                   $return = array('message' => 'Email yang Anda masukkan tidak terdaftar.', 'status' => 'error');
               }
           } else {
               $return = array('message' => validation_errors(), 'status' => 'error');
           }
           echo json_encode($return);
       } else {
           $this->template->_auth();
           $this->load->js('assets/js/modules/auth/forgot_password.min.js');

           $this->output->set_title('Lupa Password Bogatoko');
           $this->load->view('forgot_password');
       }
   }

   public function reset_password($code) {
       if ($this->aauth->logged_in())
           redirect();

       $reset = $this->aauth->forgotten_password_complete($code);
       $this->template->_auth();

       $this->output->set_title('Reset Password Bogatoko');
       if ($reset) {
           $this->load->view('forgot_password_complete');
       } else {
           $this->load->view('forgot_password_failed');
       }
   }*/

   
   function send_email($fromEmail, $fromName, $to, $cc, $subject, $template, $attach = array())
   {
       $today = date ( "Y-m-d H:i:s" );
   
       $config = Array (
               'protocol'     => 'smtp',
               'mailtype'     => 'html',
               'smtp_crypto'  => 'ssl',
               'smtp_host'    => 'smtp.gmail.com',
               'smtp_port'    => 465,
               'smtp_timeout' => 120,
               'smtp_user'    => "catatanengineer@gmail.com",
               'smtp_pass'    => 'P@$$w0rd!@#$%',
               'mailtype'     => 'html',
               'charset'      => 'utf-8',
               'crlf'         => '\r\n'
       );

       $this->load->library ( 'email' );
       $this->email->set_newline ( "\r\n" );
       $this->email->initialize ($config);
       $this->email->from ( $fromEmail, $fromName );
       $this->email->to ( $to );
       $this->email->cc ( $cc );
       $this->email->subject ( $subject );
       $this->email->message ( $template );
       if (count ( $attach ) > 0) {
           for($i = 0; $i < count ( $attach ); $i ++) {
               $this->email->attach ( $attach [$i] );
           }
       }

       if ($this->email->send ()) {
           $this->email->clear ( TRUE );
           return true;
       } else {
           echo $this->email->print_debugger();die;
           return false;
       }
   }
}
