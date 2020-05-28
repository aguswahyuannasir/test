<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->aauth->control('setting/user');

        $this->lang->load('users', settings('language'));

        $this->data['menu'] = 'setting/user/list';
        $this->data['module_url'] = site_url('settings/users/');
        $this->data['table'] = [
            'columns' => [
                '0' => ['name' => 'a.username', 'title' => lang('username'), 'class' => 'default-sort', 'sort' => 'asc', 'filter' => ['type' => 'text']],
                '1' => ['name' => 'a.email', 'title' => lang('email'), 'filter' => ['type' => 'text']],
                '2' => ['name' => 'c.name', 'title' => lang('user_group'), 'filter' => ['type' => 'text']],
            ],
            'url' => $this->data['module_url'] . 'get_list'
        ];
        if ($this->aauth->is_allowed('setting/user/edit') || ($this->aauth->is_allowed('setting/user/delete'))) {
            $this->data['table']['columns']['3'] = ['name' => 'a.id', 'title' => '', 'class' => 'no-sort text-center', 'width' => '40px', 'filter' => ['type' => 'action']];
        }
        $this->data['filter_name'] = 'table_filter_setting_user';
        $this->table = 'aauth_users';
    }

    public function index() {
        $this->data['btn_option'] = $this->aauth->is_allowed('setting/user/add') ? '<a href="' . $this->data['module_url'] . 'form" class="btn bg-success-400"><i class="icon-plus3 mr-2"></i> ' . lang('add') . '</a>' : '';

        $this->template->_init();
        $this->template->table();
        $this->output->set_title(lang('heading'));
        $this->load->view('default/list', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('datatable');

        $this->session->set_userdata($this->data['filter_name'], $this->input->post('filter'));

        $this->datatable->select("a.username, a.email, c.name user_group, a.id");
        $this->datatable->from($this->table . ' a');
        $this->datatable->join('aauth_user_to_group b', 'a.id = b.user_id', 'left');
        $this->datatable->join('aauth_groups c', 'c.id = b.group_id', 'left');
        if ($this->aauth->is_allowed('setting/user/edit') || ($this->aauth->is_allowed('setting/user/delete'))) {
            $this->datatable->edit_column("3", '<div class="list-icons">
                    <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">' .
                    ($this->aauth->is_allowed('setting/user/edit') ? '<a class="dropdown-item" href="' . $this->data['module_url'] . 'form/' . '$1">' . lang('button_edit') . '</a>' : '') .
                    ($this->aauth->is_allowed('setting/user/delete') ? '<a class="dropdown-item delete" href="' . $this->data['module_url'] . 'delete/' . '$1">' . lang('button_delete') . '</a>' : '') .
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
            $this->aauth->control('setting/user/edit');
            $data = $this->main->get($this->table, array('id' => $id));
        } else {
            $this->aauth->control('setting/user/add');
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
                    'id' => 'username',
                    'value' => ($data) ? $data->username : '',
                    'label' => lang('username'),
                    'required' => 'true',
                ),
                array(
                    'id' => 'email',
                    'type' => 'email',
                    'value' => ($data) ? $data->email : '',
                    'label' => lang('email'),
                ),
                array(
                    'id' => 'password',
                    'type' => 'password',
                    'label' => lang('password'),
                    'required' => ($data) ? false : true,
                    'help' => ($data) ? '<span class="form-text text-muted">' . lang('password_help') . '</span>' : ''
                ),
                array(
                    'id' => 'group',
                    'type' => 'dropdown',
                    'value' => ($data) ? $data->group : '',
                    'label' => lang('user_group'),
                    'options' => $this->dropdown_group(),
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

        $this->form_validation->set_rules('username', 'lang:username', 'trim|required');
        $this->form_validation->set_rules('group', 'lang:user_group', 'trim|required');
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email');
        if (!$this->input->post('id')) {
            $this->form_validation->set_rules('password', 'lang:password', 'trim|required');
        } else {
            $this->form_validation->set_rules('password', 'lang:password', 'trim');
        }

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);
            do {
                if (!$data['id']) {
                    $save = $this->aauth->create_user($data['email'], $data['password'], $data['username'], $data['group']);
                } else {
                    $save = $this->aauth->update_user($data['id'], $data['email'], $data['password'], $data['username'], $data['group']);
                }

                if (!$save) {
                    $return = array('message' => $this->aauth->print_errors(), 'status' => 'error');
                    break;
                }
                $return = array('message' => sprintf(lang('save_success'), lang('users'), $data['username']), 'status' => 'success', 'redirect' => $this->data['module_url']);
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'error');
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        
        $data = $this->aauth->get_user($id);
        
        $delete = $this->aauth->delete_user($id);
        if ($delete) {
            $return = array('message' => sprintf(lang('delete_success'), lang('users'), $data->username), 'status' => 'success');
        } else {
            $return = array('message' => sprintf(lang('delete_error'), lang('users'), $data->username), 'status' => 'error');
        }
        
        echo json_encode($return);
    }

    private function dropdown_group() {
        $groups = $this->main->gets('aauth_groups');
        if ($groups) {
            $options[0] = '';
            foreach ($groups->result() as $group) {
                $options[$group->id] = ($group->definition) ? $group->definition : $group->name;
            }
            return $options;
        }
        return false;
    }

}
