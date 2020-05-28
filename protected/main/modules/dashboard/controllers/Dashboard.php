<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->load->model('dashboard_model', 'dashboard');
        $this->lang->load('dashboard', settings('language'));
        $this->data['menu'] = 'dashboard';
    }

    public function index() {
        if ($this->data['user']->is_admin == 0) {
            redirect('org');
        }
       // aauth_log('Show dashboard', 'erp.dashboard');
       // $this->data['total_completed'] = $this->dashboard->total_cycle_status('completed');
       // $this->data['total_delivered'] = $this->dashboard->total_cycle_status('delivered');
       // $this->data['total_progress'] = $this->dashboard->total_cycle_status('on progress');
       // $this->data['total_pending'] = $this->dashboard->total_cycle_status('pending');
       // $this->data['total_planning'] = $this->dashboard->total_cycle_status('planning');

        $this->template->_init();
        // $this->load->js('assets/js/plugins/visualization/d3/d3.min.js');
        // $this->load->js('assets/js/plugins/visualization/c3/c3.min.js');
        // $this->load->js('assets/js/modules/dashboard.js');
        $this->output->set_title(lang('dashboard'));
        $this->load->view('index', $this->data);
    }

    public function daily_cycle_status() {
        $month = date('m');
        $year = date('Y');
        $date = array('x');
        $completed = array('Completed');
        $pending = array('Pending');
        $progress = array('On Progress');
        $planning = array('Planning');
        $delivered = array('Delivered');
        $datas = $this->dashboard->daily_cycle_status($year, $month);
        $row = 0;
        for ($i = 1; $i <= date('t'); $i++) {
            $data = $datas->row_array($row);
            if ($data['date'] == $i) {
                $row++;
            } else {
                $data['pending'] = 0;
                $data['planning'] = 0;
                $data['progress'] = 0;
                $data['delivered'] = 0;
                $data['completed'] = 0;
            }
            array_push($date, $i);
            array_push($pending, $data['pending']);
            array_push($planning, $data['planning']);
            array_push($progress, $data['progress']);
            array_push($delivered, $data['delivered']);
            array_push($completed, $data['completed']);
        }
        $output = array();
        array_push($output, $date);
        array_push($output, $planning);
        array_push($output, $pending);
        array_push($output, $progress);
        array_push($output, $delivered);
        array_push($output, $completed);
        echo json_encode($output);
    }

    public function customer_cycle() {
        $month = date('m');
        $year = date('Y');
        $code = array('x');
        $delivered = array('Delivered');
        $cycles = array('Cycle');
        $name = array();
        $datas = $this->dashboard->customer_cycle($year, $month);
        if ($datas->num_rows() > 0) {
            foreach ($datas->result() as $data) {
                array_push($code, $data->code);
                array_push($delivered, $data->delivered);
                array_push($cycles, $data->cycle);
                array_push($name, $data->name);
            }
        }
        $data = array();
        array_push($data, $code);
        array_push($data, $delivered);
        array_push($data, $cycles);

        $output = array('name' => $name, 'data' => $data);
        echo json_encode($output);
    }

}
