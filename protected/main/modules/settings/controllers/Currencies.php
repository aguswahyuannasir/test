<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Currencies extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->aauth->control('setting/localization/currency');

        $this->lang->load('currencies', settings('language'));

        $this->data['menu'] = 'setting/localization/currency';
        $this->data['module_url'] = site_url('settings/currencies/');
        $this->data['table'] = [
            'columns' => [
                '0' => ['name' => 'name', 'title' => lang('name'), 'class' => 'default-sort', 'sort' => 'asc', 'filter' => ['type' => 'text']],
                '1' => ['name' => 'code', 'title' => lang('code'), 'filter' => ['type' => 'text']],
            ],
            'url' => $this->data['module_url'] . 'get_list'
        ];
        if ($this->aauth->is_allowed('setting/localization/currency/edit') || ($this->aauth->is_allowed('setting/localization/currency/delete'))) {
            $this->data['table']['columns']['2'] = ['name' => 'id', 'title' => '', 'class' => 'no-sort text-center', 'width' => '40px', 'filter' => ['type' => 'action']];
        }
        $this->data['filter_name'] = 'table_filter_setting_currency';
        $this->table = 'currencies';
    }

    public function index() {
        $this->data['btn_option'] = $this->aauth->is_allowed('setting/localization/currency/add') ? '<a href="' . $this->data['module_url'] . 'form" class="btn bg-success-400"><i class="icon-plus3 mr-2"></i> ' . lang('add') . '</a>' : '';

        $this->template->_init();
        $this->template->table();
        $this->output->set_title(lang('heading'));
        $this->load->view('default/list', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('datatable');

        $this->session->set_userdata($this->data['filter_name'], $this->input->post('filter'));

        $this->datatable->select("name, code, id");
        $this->datatable->from($this->table);
        $this->datatable->where('is_deleted',0);
        if ($this->aauth->is_allowed('setting/localization/currency/edit') || ($this->aauth->is_allowed('setting/localization/currency/delete'))) {
            $this->datatable->edit_column("2", '<div class="list-icons">
                    <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">' .
                    ($this->aauth->is_allowed('setting/localization/currency/edit') ? '<a class="dropdown-item" href="' . $this->data['module_url'] . 'form/' . '$1">' . lang('button_edit') . '</a>' : '') .
                    ($this->aauth->is_allowed('setting/localization/currency/delete') ? '<a class="dropdown-item delete" href="' . $this->data['module_url'] . 'delete/' . '$1">' . lang('button_delete') . '</a>' : '') .
                    '</div>
                    </div>
                    </div>', "id");
        }
        $output = json_decode($this->datatable->generate(), true);
        echo json_encode($output);
    }

    public function form($id = '') {
        $data = array();
        if ($id) {
            $this->aauth->control('setting/localization/currency/edit');
            $data = $this->main->get($this->table, array('id' => $id));
        } else {
            $this->aauth->control('setting/localization/currency/add');
        }

        $this->load->library('form_builder');

        $this->data['form'] = [
            'action' => $this->data['module_url'] . 'save',
            'build' => $this->form_builder->build_form_horizontal([
                array(
                    'id' => 'id',
                    'type' => 'hidden',
                    'value' => ($data) ? $data->name : '',
                ),
                array(
                    'id' => 'name',
                    'value' => ($data) ? $data->name : '',
                    'label' => lang('name'),
                    'required' => 'true',
                ),
                array(
                    'id' => 'code',
                    'value' => ($data) ? $data->code : '',
                    'label' => lang('code'),
                    'required' => 'true',
                    'form_control_class' => 'col-md-2',
                ),
                array(
                    'id' => 'symbol_left',
                    'value' => ($data) ? $data->symbol_left : '',
                    'label' => lang('symbol_left'),
                    'form_control_class' => 'col-md-2',
                ),
                array(
                    'id' => 'symbol_right',
                    'value' => ($data) ? $data->symbol_right : '',
                    'label' => lang('symbol_right'),
                    'form_control_class' => 'col-md-2',
                ),
                array(
                    'id' => 'decimal_digit',
                    'type' => 'number',
                    'value' => ($data) ? $data->decimal_digit : '',
                    'label' => lang('decimal_digit'),
                    'form_control_class' => 'col-md-1',
                ),
            ])
        ];
        $this->data['data'] = $data;

        $this->template->_init();
        $this->template->form();
        $this->output->set_title(($this->data['data'] ? lang('edit') : lang('add')) . ' ' . lang('heading'));
        $this->load->view('default/form', $this->data);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'lang:name', 'trim|required');
        $this->form_validation->set_rules('code', 'lang:code', 'trim|required');

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);
            do {
                if (!$data['id']) {
                    $data['user_added'] = $this->data['user']->id;
                    $this->main->insert($this->table, $data);
                } else {
                    $data['user_modified'] = $this->data['user']->id;
                    $this->main->update($this->table, $data, array('id' => $data['id']));
                }
                $return = array('message' => sprintf(lang('save_success'), lang('currencies'), $data['name']), 'status' => 'success', 'redirect' => $this->data['module_url']);
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'error');
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $data = $this->main->get($this->table, array('id' => $id));

        $this->main->update($this->table, ['is_deleted' => 1, 'user_deleted' => $this->data['user']->id], array('id' => $id));

        $return = array('message' => sprintf(lang('delete_success'), lang('currencies'), $data->name), 'status' => 'success');

        echo json_encode($return);
    }

}
