<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Cities extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->aauth->control('setting/localization/city');

        $this->lang->load('cities', settings('language'));

        $this->data['menu'] = 'setting/localization/city';
        $this->data['module_url'] = site_url('settings/cities/');
        $this->data['table'] = [
            'columns' => [
                '0' => ['name' => 'a.name', 'title' => lang('name'), 'class' => 'default-sort', 'sort' => 'asc', 'filter' => ['type' => 'text']],
                '1' => ['name' => 'b.name', 'title' => lang('country'), 'filter' => ['type' => 'text']],
            ],
            'url' => $this->data['module_url'] . 'get_list'
        ];
        if ($this->aauth->is_allowed('setting/localization/city/edit') || ($this->aauth->is_allowed('setting/localization/city/delete'))) {
            $this->data['table']['columns']['2'] = ['name' => 'a.id', 'title' => '', 'class' => 'no-sort text-center', 'width' => '40px', 'filter' => ['type' => 'action']];
        }
        $this->data['filter_name'] = 'table_filter_setting_city';
        $this->table = 'cities';
    }

    public function index() {
        $this->data['btn_option'] = $this->aauth->is_allowed('setting/localization/city/add') ? '<a href="' . $this->data['module_url'] . 'form" class="btn bg-success-400"><i class="icon-plus3 mr-2"></i> ' . lang('add') . '</a>' : '';

        $this->template->_init();
        $this->template->table();
        $this->output->set_title(lang('heading'));
        $this->load->view('default/list', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('datatable');

        $this->session->set_userdata($this->data['filter_name'], $this->input->post('filter'));

        $this->datatable->select("a.name, b.name country, a.id");
        $this->datatable->from($this->table.' a');
        $this->datatable->join('countries b', 'b.id = a.country AND b.is_deleted = 0', 'left');
        $this->datatable->where("a.is_deleted", 0);
        if ($this->aauth->is_allowed('setting/localization/city/edit') || ($this->aauth->is_allowed('setting/localization/city/delete'))) {
            $this->datatable->edit_column("2", '<div class="list-icons">
                    <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">' .
                    ($this->aauth->is_allowed('setting/localization/city/edit') ? '<a class="dropdown-item" href="' . $this->data['module_url'] . 'form/' . '$1">' . lang('button_edit') . '</a>' : '') .
                    ($this->aauth->is_allowed('setting/localization/city/delete') ? '<a class="dropdown-item delete" href="' . $this->data['module_url'] . 'delete/' . '$1">' . lang('button_delete') . '</a>' : '') .
                    '</div>
                    </div>
                    </div>', "a.id");
        }
        $output = json_decode($this->datatable->generate(), true);
        echo json_encode($output);
    }

    public function form($id = '') {
        $data = array();
        if ($id) {
            $this->aauth->control('setting/localization/city/edit');
            $data = $this->main->get($this->table, array('id' => $id));
        } else {
            $this->aauth->control('setting/localization/city/add');
        }

        $this->load->library('form_builder');

        $this->data['form'] = [
            'action' => $this->data['module_url'] . 'save',
            'build' => $this->form_builder->build_form_horizontal([
                array(
                    'id' => 'id',
                    'type' => 'hidden',
                    'value' => ($data) ? $data->id : '',
                ),
                array(
                    'id' => 'name',
                    'value' => ($data) ? $data->name : '',
                    'label' => lang('name'),
                    'required' => 'true',
                ),
                array(
                    'id' => 'country',
                    'type' => 'dropdown',
                    'value' => ($data) ? $data->country : '',
                    'label' => lang('country'),
                    'required' => 'true',
                    'options' => $this->dropdown_country()
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
                $return = array('message' => sprintf(lang('save_success'), lang('cities'), $data['name']), 'status' => 'success', 'redirect' => $this->data['module_url']);
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

        $return = array('message' => sprintf(lang('delete_success'), lang('cities'), $data->name), 'status' => 'success');

        echo json_encode($return);
    }

    private function dropdown_country() {
        $countries = $this->main->gets('countries', ['is_deleted' => 0]);
        if ($countries) {
            $options[0] = '';
            foreach ($countries->result() as $country) {
                $options[$country->id] = $country->name;
            }
            return $options;
        }
        return false;
    }

}
