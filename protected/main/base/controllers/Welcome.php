<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->load->view('welcome_message');
    }

    public function delete_cache() {
        $all_cache = $this->cache->cache_info();
        print_r($all_cache);
        foreach ($all_cache['cache_list'] as $cache_id => $cache) :
            $this->cache->delete($cache['info']);
        endforeach;
    }

    public function test_mail() {
        $this->load->library('email');
        $this->email->initialize(array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.zoho.com',
            'smtp_user' => 'admin@armaslogistic.co.id',
            'smtp_pass' => 'P@ssw0rd',
            'smtp_port' => 465,
            'crlf' => "\r\n",
            'newline' => "\r\n",
            'mailtype' => 'html'
        ));
        $this->email->from('admin@armaslogistic.co.id');
        $this->email->to('rifkysyaripudin@gmail.com');
        $this->email->subject('Test Email');
        $this->email->message('Ini test email');

        if ($this->email->send())
            echo 'oke';
        else {
            echo $this->email->print_debugger();
        }
    }

    public function update_plan() {
        $checksheets = $this->db->where('start_plan IS NOT NULL')
                ->where('work_hours_plan', 0)
                ->get('delivery_checksheet');
        if ($checksheets->num_rows() > 0) {
            foreach ($checksheets->result() as $checksheet) {
                if ($checksheet->start_plan && $checksheet->end_plan) {
                    $data['work_hours_plan'] = work_hours($checksheet->start_plan, $checksheet->end_plan);
                    $data['overtime_plan'] = ($data['work_hours_plan'] > 9) ? $data['work_hours_plan'] - 9 : 0;
                    $this->main->update('delivery_checksheet', $data, array('id' => $checksheet->id));
                    echo $checksheet->id . ' OK<br>';
                }
            }
        }
    }

    public function work_hours() {
        $start = '2018-08-09 00:00:00';
        $end = '2018-08-09 10:50:00';
        $this->load->library('work_hours');
        $work_hours = $this->work_hours->total($start, $end);
        echo $work_hours . '<br>';
        echo $this->work_hours->total_overtime($work_hours);
    }

}
