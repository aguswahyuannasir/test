<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class User_groups extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->aauth->control('setting/user/group');

        $this->lang->load('user_groups', settings('language'));

        $this->data['menu'] = 'setting/user/group';
        $this->data['module_url'] = site_url('settings/user_groups/');
        $this->data['table'] = [
            'columns' => [
                '0' => ['name' => 'name', 'title' => lang('name'), 'class' => 'default-sort', 'sort' => 'asc', 'filter' => ['type' => 'text']],
                '1' => ['name' => 'definition', 'title' => lang('definition'), 'filter' => ['type' => 'text']],
            ],
            'url' => $this->data['module_url'] . 'get_list'
        ];
        if ($this->aauth->is_allowed('setting/user/group/edit') || ($this->aauth->is_allowed('setting/user/group/delete'))) {
            $this->data['table']['columns']['2'] = ['name' => 'id', 'title' => '', 'class' => 'no-sort text-center', 'width' => '40px', 'filter' => ['type' => 'action']];
        }
        $this->data['filter_name'] = 'table_filter_setting_group';
        $this->table = 'aauth_groups';
    }

    public function index() {
        $this->data['btn_option'] = $this->aauth->is_allowed('setting/user/group/add') ? '<a href="' . $this->data['module_url'] . 'form" class="btn bg-success-400"><i class="icon-plus3 mr-2"></i> ' . lang('add') . '</a>' : '';

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
        if ($this->aauth->is_allowed('setting/user/group/edit') || ($this->aauth->is_allowed('setting/user/group/delete'))) {
            $this->datatable->edit_column("2", '<div class="list-icons">
                    <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">' .
                    ($this->aauth->is_allowed('setting/user/group/edit') ? '<a class="dropdown-item" href="' . $this->data['module_url'] . 'form/' . '$1">' . lang('button_edit') . '</a>' : '') .
                    ($this->aauth->is_allowed('setting/user/group/delete') ? '<a class="dropdown-item delete" href="' . $this->data['module_url'] . 'delete/' . '$1">' . lang('button_delete') . '</a>' : '') .
                    '</div>
                    </div>
                    </div>', "id");
        }
        $output = json_decode($this->datatable->generate(), true);
        echo json_encode($output);
    }

    public function form($id = '') {
        $data = array();
        $perm_exist = array();
        if ($id) {
            $this->aauth->control('setting/user/group/edit');
            $data = $this->main->get($this->table, array('id' => $id));
            $permissions = $this->main->gets('aauth_perm_to_group', array('group_id' => $id));
            if ($permissions) {
                foreach ($permissions->result() as $perm) {
                    array_push($perm_exist, $perm->perm_id);
                }
            }
        } else {
            $this->aauth->control('setting/user/group/add');
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
                    'id' => 'definition',
                    'value' => ($data) ? $data->definition : '',
                    'label' => lang('definition'),
                ),
                array(
                    'id' => 'permission',
                    'type' => 'html',
                    'label' => lang('permission'),
                    'html' => $this->load->view('form_user_group_permission_list', ['perm_exist' => $perm_exist, 'permissions' => $this->main->gets('aauth_perms', [], 'name asc')], true)
                ),
            ])
        ];
        $this->data['data'] = $data;

        $this->template->_init();
        $this->template->form();
        $this->load->js('assets/js/plugins/forms/duallistbox.min.js');
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
                    $save = $this->aauth->create_group($data['name'], $data['definition']);
                    if (!$save) {
                        $return = array('message' => $this->aauth->print_infos(), 'status' => 'error');
                        break;
                    } else {
                        $permissions = array_filter($data['permission']);
                        if ($permissions) {
                            $data_perm = array();
                            foreach ($permissions as $perm) {
                                array_push($data_perm, array('perm_id' => $perm, 'group_id' => $save));
                            }
                            $this->db->insert_batch('aauth_perm_to_group', $data_perm);
                        }
                    }
                } else {
                    $this->main->update('aauth_groups', array('name' => $data['name'], 'definition' => $data['definition']), array('id' => $data['id']));
                    $this->main->delete('aauth_perm_to_group', array('group_id' => $data['id']));
                    $permissions = array_filter($data['permissions']);
                    if ($permissions) {
                        $data_perm = array();
                        foreach ($permissions as $perm) {
                            array_push($data_perm, array('perm_id' => $perm, 'group_id' => $data['id']));
                        }
                        $this->db->insert_batch('aauth_perm_to_group', $data_perm);
                    }
                }
                $return = array('message' => sprintf(lang('save_success'), lang('user_groups'), $data['name']), 'status' => 'success', 'redirect' => $this->data['module_url']);
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

        $return = array('message' => sprintf(lang('delete_success'), lang('groups'), $data->name), 'status' => 'success');

        echo json_encode($return);
    }

}
