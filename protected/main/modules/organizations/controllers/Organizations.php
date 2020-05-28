<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Organizations extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('organizations', settings('language'));
        $this->load->model('organizations_model');

        $this->data['menu']       = 'dashboard';
        $this->data['module_url'] = site_url('org/');
        /*$cookies = $this->input->cookie();
        debugCode($cookies);*/
    }

    public function index() {
       
        // $this->data['organizations'] = array();
        // $this->data['myorganizations'] = $this->organizations_model->get_companyList($this->data['user']->id);

        if($this->data['user']->is_admin){
            $this->data['organizations']  = array();
            $this->data['members_filter'] = NULL;
            $this->data['members']        = NULL;
            $this->data['owner_id']       = array();
            $this->data['companyList']    = $this->organizations_model->get_companyList('');
            if($this->data['companyList']){
                foreach($this->data['companyList'] as $key => $val){
                    //var_dump($this->data['owner_id']);exit();
                    //if(!in_array($val->id,$this->data['owner_id'])){
                       // array_push($this->data['owner_id'],$val->id);
                        $this->data['members'][] = $this->organizations_model->get_members_2($val->id)[0];
                    //}
                }
                
                foreach($this->data['members'] as $key => $val){
                    if(!in_array($val->id,$this->data['owner_id'])){
                        array_push($this->data['owner_id'],$val->id);
                        $this->data['members_filter'][] = $val;
                    }
                }
            }
            if($this->data['members_filter']){
                foreach($this->data['members_filter'] as $key => $val){
                    $this->data['organizations'][$val->id] = $this->organizations_model->get_all($val->id);
                }
            }
            $this->load->view('index_admin', $this->data);
        } else {
            $get_list_organizations                 = $this->organizations_model->get_organizations();
            $this->data['get_list_filter']          = $get_list_organizations;
            
            $get_val = $this->input->post();

            $this->data['filter_org']= @$get_val['filter_org'];

            $filter_organization = @$get_val['filter_org'];
// var_dump($filter_organization);die();
            $get_organization  = $this->organizations_model->get_all($this->data['user']->id,$filter_organization);
            $list_organization = [];
            foreach ($get_organization as $lokey => $lovalue) {
                if ($lovalue->invitation_id != 0 AND $lovalue->invitation_id != "") {
                    $check_invitation_status = $this->organizations_model->check_invitation($lovalue->organization, $this->data['user']->id, $lovalue->invitation_id);
                    if ($check_invitation_status->status == 1) {
                        $list_organization[] = $lovalue;
                    }
                }else{
                    $list_organization[] = $lovalue;
                }
            }
            $this->data['organizations'] = $list_organization;
            if (!empty($this->data['organizations'])) {
                $count_org = count($this->data['organizations']);
            }else{
                $count_org = 0;
            }

            /*======= START FOR DASHBOARD TAB*/
            if ($count_org < 1) {
                $dashboard = [
                    "current" => 0,
                    "draft"   => 0,
                    "overdue" => $this->listOverdue()
                ];
            }else{
                $idOrg = [];
                foreach ($this->data['organizations'] as $orkey => $orvalue) {
                    $idOrg[] = $orvalue->organization;
                }
                $year    = date("Y");
                $overdue = $this->listOverdue();
                foreach ($overdue as $okey => $ovalue) {
                    $getOver = $this->organizations_model->sum_overdue($ovalue, $idOrg);
                    $overdue[$okey]['total'] = $getOver->sums;
                }
                
                $getDash['dashCurrent']    = $this->organizations_model->sum_invoice_current($year, $idOrg);
                $getDash['dashCurrentSub'] = $this->organizations_model->sum_current_sub($year, $idOrg);
                $getDash['draft']          = $this->organizations_model->sum_invoice_draft($year, $idOrg);
                $getDash['overdue']        = $overdue;

                $dashboard = [
                    "current" => ($getDash['dashCurrent']->current + $getDash['dashCurrentSub']->current_sub),
                    "draft"   => $getDash['draft']->current,
                    "overdue" => $getDash['overdue']
                ];
            }
            

            $this->data['dashboard'] = $dashboard;
            /*======= END FOR DASHBOARD TAB*/
            if ($count_org == 1 AND $this->data['user']->owner_id != "") {
                redirect('launch?cid='.encode($this->data['organizations'][0]->organization));
            }
            $this->load->view('index', $this->data);
        }
        // if($this->data['members']){
        //     foreach($this->data['members'] as $key => $val){
        //         $this->data['organizations'][$val->id] = $this->organizations_model->get_all($val->id);
        //     }
        // }
        
        $this->template->_init();
        $this->output->set_title(lang('heading'));
    }

    private function listOverdue(){
        $overdue[0] = [
            "start" => date("Y-m-d", strtotime("-15 days")),
            "end"   => date("Y-m-d"),
            "type"  => "BETWEEN",
            "total" => 0
        ];
        $overdue[1] = [
            "start" => date("Y-m-d", strtotime("-30 days")),
            "end"   => date("Y-m-d", strtotime("-16 days")),
            "type"  => "BETWEEN",
            "total" => 0
        ];
        $overdue[2] = [
            "start" => date("Y-m-d", strtotime("-45 days")),
            "end"   => date("Y-m-d", strtotime("-31 days")),
            "type"  => "BETWEEN",
            "total" => 0
        ];
        $overdue[3] = [
            "start" => date("Y-m-d", strtotime("-46 days")),
            "end"   => "",
            "type"  => "BELOW",
            "total" => 0
        ];

        return $overdue;
    }

    public function pricing() {
        //$this->data['organizations'] = $this->organizations_model->get_all($this->data['user']->id);
        $this->load->view('pricing', $this->data);
        
        
        $this->template->_init();
        $this->output->set_title(lang('heading'));
    }

    public function add() {
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            if ($this->form_validation->run() == true) {
                $data = $this->input->post(null, true);
                $signature = ['image' => '', 'as' => '', 'name' => '', 'job_title' => ''];
                $org = $this->main->insert('organizations', [
                    'name' => $data['name'],
                    'package' => $data['package'],
                    'start_from' => date('Y-m-d'),
                    'valid_until' => date('Y-m-d',strtotime('+30 days',strtotime(date('Y-m-d')))),
                    'status' => 1,
                    'template_sale_invoice_options' => json_encode(['signature_count' => 0, 'logo' => false, 'organization_name' => true, 'organization_address' => true, 'organization_contact' => true, 'product_code' => true, 'product_tax' => true]),
                    'template_sale_quote_options' => json_encode(['signature_count' => 0, 'logo' => false, 'organization_name' => true, 'organization_address' => true, 'organization_contact' => true, 'product_code' => true, 'product_tax' => true]),
                    'template_purchase_invoice_options' => json_encode(['signature_count' => 0, 'logo' => false, 'organization_name' => true, 'organization_address' => true, 'organization_contact' => true, 'product_code' => true, 'product_tax' => true]),
                    'template_purchase_order_options' => json_encode(['signature_count' => 0, 'logo' => false, 'organization_name' => true, 'organization_address' => true, 'organization_contact' => true, 'product_code' => true, 'product_tax' => true]),
                    'template_purchase_quote_options' => json_encode(['signature_count' => 0, 'logo' => false, 'organization_name' => true, 'organization_address' => true, 'organization_contact' => true, 'product_code' => true, 'product_tax' => true]),
                    'signatures' => json_encode([$signature, $signature, $signature, $signature])
                ]);
                $this->main->insert('organization_members', ['organization' => $org, 'member' => $this->data['user']->id, 'role' => 'owner']);
                $this->main->insert('currencies', ['organization' => $org, 'user_added' => $this->data['user']->id, 'code' => 'IDR', 'name' => 'Rupiah', 'prefix' => 'Rp ', 'decimal_digit' => '0', 'decimal_separator' => ',', 'thousand_separator' => '.', 'is_default' => 1]);
                mkdir('files/' . $org);
                chmod('files/' . $org, 0777);
                redirect();
            } else {
                $this->data['error'] = true;
            }
        }
        $this->data['packages'] = $this->organizations_model->get_packages();
       
        $this->template->_init();
        $this->output->set_title(lang('add_organization'));
        $this->load->view('form', $this->data);
    }

    public function delete($id) {
        //        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        //        $data = $this->main->get('organizations', array('id' => $id));

        $this->main->update('organizations', ['is_deleted' => 1, 'user_deleted' => $this->data['user']->id], array('id' => $id));
        redirect();
        //        $return = array('message' => sprintf(lang('delete_success'), lang('categories'), $data->title), 'status' => 'success');
        //
        //        echo json_encode($return);
    }

    public function getListInvoice(){
        $requestParam           = $_REQUEST;
        $getData                = $this->organizations_model->get_list_data ( $requestParam, 'nofilter' );
        $totalAllData           = $this->organizations_model->get_list_data ( $requestParam, 'nofilter', 'all' )->row ()->total_data;
        $totalDataFiltered      = $this->organizations_model->get_list_data ( $requestParam, 'nofilter', 'all' )->row ()->total_data;

        if (empty ( $requestParam ['search'] ['value'] ) > 1) {
            $getData            = $this->organizations_model->get_list_data ( $requestParam );
            $totalDataFiltered  = $getData->num_rows ();
        }

        $listData = array ();
        $no = ($requestParam['start']+1);
        foreach( $getData->result () AS $value){
            $rowData    = array();
            /*========================================= BEGIN BUTTON STUFF =========================================*/
            $button = "<button type='button' class='btn btn-sm btn-primary' onclick='moreInfo(".$value->id.")'>More Info</button>";
            $status = salesStatusLabel($value->status);
            /*========================================= END BUTTON STUFF =========================================*/
            // $rowData[] = $no++;
            // $rowData[] = $value->name;
            // $rowData[] = date("F", strtotime($value->date));
            // $rowData[] = $value->status;
            // $rowData[] = $value->customer_name;
            // $rowData[] = $value->subject;
            // $rowData[] = $value->date;
            // $rowData[] = "<div style='width:100%; text-align:right;'>".$value->currency_prefix.number_format($value->subtotal)."<div>";
            // $rowData[] = "<div style='width:100%; text-align:right;'>".$value->currency_prefix.number_format($value->total)."</div>";

            $rowData[] = "<span id='tb_".$value->id."'>".$no++."</span>";
            $rowData[] = $value->name;
            $rowData[] = date("F", strtotime($value->date));
            $rowData[] = $value->code;
            $rowData[] = $status;
            $rowData[] = $value->customer_name;
            $rowData[] = $value->subject;
            $rowData[] = $value->date;
            $rowData[] = $button;

            $listData[] = $rowData;
            
            $json_data = array (
                "draw"            => intval ( $requestParam ['draw'] ), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
                "recordsTotal"    => intval ( $totalAllData ), // total number of records
                "recordsFiltered" => intval ( $totalDataFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $listData 
            ); // total data array
        }
        if(empty($json_data)){
            $json_data = array (
                "draw"            => 0, // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
                "recordsTotal"    => 0, // total number of records
                "recordsFiltered" => 0, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => ""
            ); // total data array
        }
        header ( 'Content-Type: application/json;charset=utf-8' );
        echo json_encode ($json_data);
        die();
    }


    function getMoreInfo($id){
        $data = $this->organizations_model->getMoreInfo($id);
        // debugCode($data);
        return $this->load->view('detail_info', $data);
        //echo "Hello";
    }

    function get_filter_org($id=NULL){
        $x = site_url();

        var_dump($x);die();
            if(is_null($id)){
                // $q          = $_GET['q'];
                // $parent     = $this->m_global->getDataAll('m_user', NULL,['USER_INITIAL LIKE' => '%'.$q.'%'],'USER_INITIAL, USER_INITIAL',"FIND_IN_SET( '2', USER_ROLE_ID ) AND USER_INITIAL !='unknown'",['USER_INITIAL','ASC']);
                // $data = [];
                // for ($i=0; $i < count($parent); $i++) {
                //     $data[$i] = ['id' => $parent[$i]->USER_INITIAL, 'name' => $parent[$i]->USER_INITIAL];
                // }
                // echo json_encode(['item' => $data]);
            }else{
                // $id         = str_replace('-', ',', $id);
                // $where_e    = " `USER_INITIAL` IN (".$id.")";
                // $parent     = $this->m_global->getDataAll('m_user', NULL, NULL, 'USER_INITIAL, USER_INITIAL', $where_e);
                // $data       = [];
                // for ($i=0; $i < count($parent); $i++) {
                //     $data[$i] = ['id' => $parent[$i]->USER_INITIAL, 'name' => $parent[$i]->USER_INITIAL];
                // }
                // echo json_encode($data);
            }
    }

}
