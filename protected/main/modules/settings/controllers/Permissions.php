<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Permissions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->aauth->control('setting/user/permission');

        $this->lang->load('permissions', settings('language'));

        $this->data['menu'] = 'setting/user/permission';
        $this->data['module_url'] = site_url('settings/permissions/');
        $this->data['table'] = [
            'columns' => [
                '0' => ['name' => 'name', 'title' => lang('name'), 'class' => 'default-sort', 'sort' => 'asc', 'filter' => ['type' => 'text']],
                '1' => ['name' => 'definition', 'title' => lang('definition'), 'filter' => ['type' => 'text']],
            ],
            'url' => $this->data['module_url'] . 'get_list'
        ];
        if ($this->aauth->is_allowed('setting/user/permission/edit') || ($this->aauth->is_allowed('setting/user/permission/delete'))) {
            $this->data['table']['columns']['2'] = ['name' => 'id', 'title' => '', 'class' => 'no-sort text-center', 'width' => '40px', 'filter' => ['type' => 'action']];
        }
        $this->data['filter_name'] = 'table_filter_setting_permission';
        $this->table = 'aauth_perms';
    }

    public function index() {
        $this->data['btn_option'] = $this->aauth->is_allowed('setting/user/permission/add') ? '<a href="' . $this->data['module_url'] . 'form" class="btn bg-success-400"><i class="icon-plus3 mr-2"></i> ' . lang('add') . '</a>' : '';

        $this->template->_init();
        $this->template->table();
        $this->output->set_title(lang('heading'));
        $this->load->view('default/list', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('datatable');

        $this->session->set_userdata($this->data['filter_name'], $this->input->post('filter'));

        $this->datatable->select("name, definition, id");
        $this->datatable->from($this->table);
        if ($this->aauth->is_allowed('setting/user/permission/edit') || ($this->aauth->is_allowed('setting/user/permission/delete'))) {
            $this->datatable->edit_column("2", '<div class="list-icons">
                    <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">' .
                    ($this->aauth->is_allowed('setting/user/permission/edit') ? '<a class="dropdown-item" href="' . $this->data['module_url'] . 'form/' . '$1">' . lang('button_edit') . '</a>' : '') .
                    ($this->aauth->is_allowed('setting/user/permission/delete') ? '<a class="dropdown-item delete" href="' . $this->data['module_url'] . 'delete/' . '$1">' . lang('button_delete') . '</a>' : '') .
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
            $this->aauth->control('setting/user/permission/edit');
            $data = $this->main->get($this->table, array('id' => $id));
        } else {
            $this->aauth->control('setting/user/permission/add');
        }

        $this->load->library('form_builder');

        $this->data['form'] = [
            'action' => $this->data['module_url'] . 'save',
            'build' => $this->form_builder->build_form_horizontal([
                array(
                    'id' => 'perm',
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
                    'id' => 'definition',
                    'value' => ($data) ? $data->definition : '',
                    'label' => lang('definition'),
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

        $this->form_validation->set_rules('name', 'lang:name', 'trim|required|seo_url');

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);
            do {
                if (!$data['perm']) {
                    $save = $this->aauth->create_perm($data['name'], $data['definition']);
                    if (!$save) {
                        $return = array('message' => $this->aauth->print_infos(), 'status' => 'error');
                    } else {
                        $return = array('message' => sprintf(lang('save_success'), lang('permissions'), $data['name']), 'status' => 'success', 'redirect' => $this->data['module_url']);
                    }
                } else {
                    $this->aauth->update_perm($data['perm'], $data['name'], $data['definition']);
                    $return = array('message' => sprintf(lang('save_success'), lang('permission'), $data['name']), 'status' => 'success', 'redirect' => $this->data['module_url']);
                }
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'error');
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $data = $this->main->get($this->table, array('id' => $id));
        $delete = $this->aauth->delete_perm($id);
        if (!$delete) {
            $return = array('message' => $this->aauth->print_infos(), 'status' => 'error');
        } else {
            $return = array('message' => sprintf(lang('delete_success'), lang('permissions'), $data->name), 'status' => 'success');
        }
        echo json_encode($return);
    }

}
