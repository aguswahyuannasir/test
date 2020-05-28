<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("user_model", "M_user");
        $this->data['menu'] = 'user';
    }

    public function index() {
        $this->template->_init();

        $owner = $this->data['user']->owner_id;
        if ($owner == "") {
            $owner = $this->data['user']->id;
        }

        if ($this->data['user']->is_admin == 0) {
            $listUser = $this->M_user->listUserOwner($owner);
            foreach ($listUser as $key => $value) {
                $getOrg = $this->M_user->getOrganizationByOwnerUser($value->id);
                foreach ($getOrg as $gokey => $govalue) {
                    if ($govalue->invitation_id != 0 AND $govalue->status == "") {
                        unset($getOrg[$gokey]);
                    }
                }
                
                $listUser[$key]->listOrg = $getOrg;
            }


            $listInvited = $this->M_user->getInvitedMemberOwner($owner);
            foreach ($listInvited as $likey => $livalue) {
                $getOrg = $this->M_user->invitedOrg($livalue->member_id, $owner);
                $listInvited[$likey]->listOrg = $getOrg;
            }


            $this->data['listInvited'] = $listInvited;
            $this->data['listUser']    = $listUser;
            $this->load->view('index', $this->data);
        }else{
            $this->load->view('index_admin', $this->data);
        }
    }

    public function add(){
        $get   = $this->input->get();
        $owner = $this->data['user']->owner_id;
        if ($owner == "") {
            $owner = $this->data['user']->id;
        }

        $default = "";
        if (isset($get['default'])) {
            $default = decode($get['default']);
        }
        
        $this->data['default_org'] = $default;

        $listOrg    = $this->M_user->getOrganizationByOwner($owner);

        $listModule = $this->M_user->getModule();
        $module     = [];
        foreach ($listModule as $mkey => $mvalue) {
            if ($mvalue->is_parent == 1) {
                $getChild = $this->M_user->getModuleSub($mvalue->id);
                foreach ($getChild as $sckey => $scvalue) {
                    if ($scvalue->is_parent == 1) {
                        $getAnotherchild = $this->M_user->getModuleSubChild($scvalue->id);
                        $scvalue->child = $getAnotherchild;
                    }
                    $getChild[$sckey] = $scvalue;
                }
                $mvalue->child = $getChild;
            }else{
                $mvalue->child = [];
            }
            $module[] = $mvalue;
        }
        // debugCode($module);
        $this->data['user_listmodule'] = $module;
        $this->data['list_org']        = $listOrg;

        $this->template->_init();
        $this->load->view('add', $this->data);
    }

    public function doadd(){
        $post  = $this->input->post();

        $owner = $this->data['user']->owner_id;
        if ($owner == "") {
            $owner = $this->data['user']->id;
        }

        $post['user_email'] = str_replace(" ", $post['user_email'], $post['user_email']);
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $checkEmail = $this->M_user->checkEmailUser($post['user_email']);
            if ($checkEmail == 0) {
                // SETTING GROUP MEMBER
                $group = "user";
                // INSERT TO TBL members
                $regis = $this->aauth->create_user($post['user_email'], $post['user_password'], FALSE, $group);
                $this->db->update('members', ['fullname' => $post['user_name'], "owner_id" => $owner], ['id' => $regis]);

                // CLEAR CURRENT MODULE INSTALLATION
                // $this->db->delete("member_module", ['member_id' => $regis]);
                // $this->db->delete("member_module_sub", ['member_id' => $regis]);

                // $this->db->delete("organization_members", ['member' => $regis]);
                // ALLOWED ORGANIZATION
                if (isset($post['org'])) {
                    foreach ($post['org'] as $okey => $ovalue) {
                        $orgInsArray = [
                            "organization" => $ovalue,
                            "member"       => $regis,
                            "role"         => $group
                        ];
                        $this->db->insert("organization_members", $orgInsArray);

                        // ALLOWED MODULE
                        if (isset($post['module'])) {
                            if (isset($post['module'][$okey])) {
                                foreach ($post['module'][$okey] as $mdkey => $mdvalue) {
                                    $inserModule = [
                                        "member_id"    => $regis,
                                        "module_id"    => $mdkey,
                                        "organization" => $ovalue
                                    ];
                                    $this->db->insert("member_module", $inserModule);
                                }
                            }   
                        }

                        // ALLOWED SUB MODULE
                        if (isset($post['module_sub'])) {
                            if (isset($post['module_sub'][$okey])) {
                                foreach ($post['module_sub'][$okey] as $mskey => $msvalue) {
                                    $inserModule = [
                                        "member_id"    => $regis,
                                        "module_id"    => $mskey,
                                        "organization" => $ovalue
                                    ];
                                    $this->db->insert("member_module", $inserModule);
                                    foreach ($msvalue as $sbkey => $sbvalue) {
                                        $insertMemberSub = [
                                            "member_id"     => $regis,
                                            "module_id"     => $mskey,
                                            "module_sub_id" => $sbkey,
                                            "organization"  => $ovalue 
                                        ];
                                        $this->db->insert("member_module_sub", $insertMemberSub);
                                        if(is_array($sbvalue)){
                                            // INSERT SECOND CHILD SUBMEMBER
                                            foreach ($sbvalue as $sckey => $scvalue) {
                                                $insertMemberSubChild = [
                                                    "member_id"     => $regis,
                                                    "module_id"     => $mskey,
                                                    "module_sub_id" => $sckey,
                                                    "organization"  => $ovalue
                                                ];
                                                $this->db->insert("member_module_sub", $insertMemberSubChild);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">Add user success</div>');
                redirect('user');
            }else{
                $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Email already exist, please use another email address.!</div>');
                redirect('add-user');
            }
        }else{
            $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Form Validation Failed.!</div>');
            redirect('add-user');
        }
    }

    public function doedit(){
        $get = $this->input->get();
        if (!isset($get['parameter']) or empty($get['parameter'])) { redirect(''); }

        $decode = decode($get['parameter']);
        if (empty($decode)) { redirect(''); }

        $search = strstr($decode, "invited");
        if (!empty($search)) {
           $decode = str_replace("invited-", "", $decode);
        }

        /*====== START SAME AS ADD =====*/
        $owner = $this->data['user']->owner_id;
        if ($owner == "") {
            $owner = $this->data['user']->id;
        }

        $listOrg    = $this->M_user->getOrganizationByOwner($owner);
        $listModule = $this->M_user->getModule();
        $module     = [];
        foreach ($listModule as $mkey => $mvalue) {
            if ($mvalue->is_parent == 1) {
                $getChild = $this->M_user->getModuleSub($mvalue->id);
                foreach ($getChild as $sckey => $scvalue) {
                    if ($scvalue->is_parent == 1) {
                        $getAnotherchild = $this->M_user->getModuleSubChild($scvalue->id);
                        $scvalue->child = $getAnotherchild;
                    }
                    $getChild[$sckey] = $scvalue;
                }
                $mvalue->child = $getChild;
            }else{
                $mvalue->child = [];
            }
            $module[] = $mvalue;
        }

        $this->data['user_listmodule'] = $module;
        $this->data['list_org']        = $listOrg;
        /*===== END SAME AS ADD =====*/
        $org = [];
        foreach ($listOrg as $orgkey => $orgvalue) {
            $org[] = $orgvalue->id;
        }

        $dataUser            = $this->M_user->getUserDetail($decode);
        $listInstalledModule = $this->M_user->getModuleListInstalled($decode, $org);
        $listInstalledSub    = $this->M_user->listInstalledSub($decode, $org);
        $listInstalledOrg    = $this->M_user->listInstalledOrg($decode);

        // Installed Organizations
        $insOrg = [];
        foreach ($listInstalledOrg as $lokey => $lovalue) {
            $insOrg[$lovalue->organization] = "";
        }

        // Installed Module
        $insModule = [];
        foreach ($listInstalledModule as $lmkey => $lmvalue) {
            $insModule[$lmvalue->organization][$lmvalue->module_id] = "";
        }

        // Installed Sub Module
        $insSub = [];
        foreach ($listInstalledSub as $lskey => $lsvalue) {
            $insSub[$lsvalue->organization][$lsvalue->module_sub_id] = "";
        }

        $this->data['userData']  = $dataUser;
        $this->data['insOrg']    = $insOrg;
        $this->data['insModule'] = $insModule;
        $this->data['insSub']    = $insSub;

        $this->template->_init();
        if (!empty($search)) {
            $this->load->view('edit_invited', $this->data);
        }else{
            $this->load->view('edit', $this->data);
        }
    }

    public function doupdate(){
        $post = $this->input->post();
        
        $owner = $this->data['user']->owner_id;
        if ($owner == "") {
            $owner = $this->data['user']->id;
        }

        if (!isset($post['parameter'])) {
            redirect('');
        }

        $member_id = decode($post['parameter']);

        $search = strstr($member_id, "invited");
        if (!empty($search)) {
           $member_id = str_replace("invited-", "", $member_id);
        }

        if (empty($search)) {
            if ($post['user_email'] != $post['current_email']) {
                $checkEmail = $this->M_user->checkEmailUser($post['user_email']);
                if ($checkEmail > 0) {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Email already exist, please use another email address.!</div>');
                    redirect('add-user');
                }
            }

            $update = [
                "fullname" => $post['user_name'],
                "email"    => $post['user_email']
            ];

            if ($post['user_password'] != "") {
                $update['pass'] = $this->aauth->hash_password($post['user_password'], 0);
            }
            $this->db->update("members", $update, ['id' => $member_id]);
        }

        $group = "user";

        // ALLOWED ORGANIZATION
        if (isset($post['org'])) {
            $listOrg    = $this->M_user->getOrganizationByOwner($owner);
            $orgnyawhere = [];
            foreach ($listOrg as $orkey => $orvalue) {
                $orgnyawhere[] = "organization = ".$orvalue->id;
            }

            // FOR THE FIRST TIME
            $this->db->query("DELETE FROM member_module WHERE member_id= ".$member_id." AND organization IS NULL;");
            $this->db->query("DELETE FROM member_module_sub WHERE member_id= ".$member_id." AND organization IS NULL;");

            if (empty($search)) {    
                $this->db->query("DELETE FROM organization_members WHERE member=".$member_id." AND (".implode(" or ", $orgnyawhere).")");
                // $this->db->delete("organization_members", ['member' => $member_id, "invitation_id" => 0]);
                $this->db->query("DELETE FROM member_module WHERE member_id= ".$member_id." AND (".implode(" or ", $orgnyawhere).")");
                $this->db->query("DELETE FROM member_module_sub WHERE member_id= ".$member_id." AND (".implode(" or ", $orgnyawhere).")");
            }else{
                $this->db->query("DELETE FROM organization_members WHERE member=".$member_id." AND (".implode(" or ", $orgnyawhere).")");
                $this->db->query("DELETE FROM member_module WHERE member_id= ".$member_id." AND (".implode(" or ", $orgnyawhere).")");
                $this->db->query("DELETE FROM member_module_sub WHERE member_id= ".$member_id." AND (".implode(" or ", $orgnyawhere).")");
            }
            foreach ($post['org'] as $okey => $ovalue) {
                // CLEAR CURRENT MODULE INSTALLATION
                // $this->db->delete("member_module", ['member_id' => $member_id, "organization" => $ovalue]);
                // $this->db->delete("member_module_sub", ['member_id' => $member_id, "organization" => $ovalue]);

                $orgInsArray = [
                    "organization" => $ovalue,
                    "member"       => $member_id,
                    "role"         => $group
                ];
                if (!empty($search)) {
                    $getInvitedMember = $this->M_user->getInvitedMember($member_id, $owner);
                    $orgInsArray['invitation_id'] = $getInvitedMember->id;
                }
                $this->db->insert("organization_members", $orgInsArray);

                // ALLOWED MODULE
                if (isset($post['module'])) {
                    if (isset($post['module'][$okey])) {
                        foreach ($post['module'][$okey] as $mdkey => $mdvalue) {
                            $inserModule = [
                                "member_id"    => $member_id,
                                "module_id"    => $mdkey,
                                "organization" => $ovalue
                            ];
                            $this->db->insert("member_module", $inserModule);
                        }
                    }
                }

                // ALLOWED SUB MODULE
                if (isset($post['module_sub'])) {
                    if (isset($post['module_sub'][$okey])) {
                        foreach ($post['module_sub'][$okey] as $mskey => $msvalue) {
                            $inserModule = [
                                "member_id"    => $member_id,
                                "module_id"    => $mskey,
                                "organization" => $ovalue
                            ];
                            $this->db->insert("member_module", $inserModule);
                            foreach ($msvalue as $sbkey => $sbvalue) {
                                $insertMemberSub = [
                                    "member_id"     => $member_id,
                                    "module_id"     => $mskey,
                                    "module_sub_id" => $sbkey,
                                    "organization"  => $ovalue
                                ];
                                $this->db->insert("member_module_sub", $insertMemberSub);
                                if(is_array($sbvalue)){
                                    // INSERT SECOND CHILD SUBMEMBER
                                    foreach ($sbvalue as $sckey => $scvalue) {
                                        $insertMemberSubChild = [
                                            "member_id"     => $member_id,
                                            "module_id"     => $mskey,
                                            "module_sub_id" => $sckey,
                                            "organization"  => $ovalue
                                        ];
                                        $this->db->insert("member_module_sub", $insertMemberSubChild);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">Update user success</div>');
        redirect('user');
    }

    public function dodelete(){
        $get = $this->input->get();

        if (!isset($get['parameter'])) {
            redirect('');
        }

        $member_id = decode($get['parameter']);
        $this->db->update("members", ['is_deleted' => 1, 'updated_by' => $this->data['user']->id, 'updated_date' => date("Y-m-d H:i:s")], ['id' => $member_id]);

        $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">Delete user success</div>');
        redirect('user');   
    }

    public function checkemailinvitation(){
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $get = $this->input->get();
        
        $email = $get['email'];
        $validation = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!empty($validation)) {
            $checkEmailUser = $this->M_user->checkEmailUser2($email);
            // debugCode($checkEmailUser);
            if (!empty($checkEmailUser)) {
                $owner = $this->data['user']->owner_id;
                if ($owner == "") {
                    $owner = $this->data['user']->id;
                }

                if ($owner == $checkEmailUser->owner_id) {
                    $listOrg    = $this->M_user->getOrganizationByOwner($owner);
                    $listOrg_member = $this->M_user->getOrganizationByOwnerUser($checkEmailUser->id);
                    // debugCode($listOrg_member);
                    $org = "<label>Select Organization</label><br>";
                    foreach ($listOrg as $lokey => $lovalue) {
                        $search_col = array_search($lovalue->id, array_column($listOrg_member, 'id'));
                        if(json_encode($search_col) == "false"){
                            $org.="<input type='checkbox' name='organization[]' value='".$lovalue->id."'> ".$lovalue->name."<br>";
                        }   
                    }

                    $json_return = [
                        "status"     => "OK",
                        "message"    => "Email valid as your own member.",
                        "alert"      => "alert alert-success",
                        "code"       => 003,
                        "additional" => $org
                    ];
                }else{
                    $checkInvited = $this->M_user->check_member_invitation_id_available($checkEmailUser->id, $owner);
                    if (!empty($checkInvited)) {
                        $listOrg    = $this->M_user->getOrganizationByOwner($owner);
                        //debugCode($listOrg);
                        $org = "<label>Select Organization</label><br>";
                        foreach ($listOrg as $lokey => $lovalue) {
                            $org.="<input type='checkbox' name='organization[]' value='".$lovalue->id."'> ".$lovalue->name."<br>";
                        }
                        $json_return = [
                            "status"     => "ERROR",
                            "message"    => "You have invited this user, go to edit access for user for more detail",
                            "alert"      => "alert alert-warning",
                            "code"       => 002,
                            "additional" => ""
                        ];
                    }else{
                        $listOrg    = $this->M_user->getOrganizationByOwner($owner);
                        //debugCode($listOrg);
                        $org = "<label>Select Organization</label><br>";
                        foreach ($listOrg as $lokey => $lovalue) {
                            $org.="<input type='checkbox' name='organization[]' value='".$lovalue->id."'> ".$lovalue->name."<br>";
                        }
                        $json_return = [
                            "status"     => "OK",
                            "message"    => "Email Valid.",
                            "alert"      => "alert alert-success",
                            "code"       => 001,
                            "additional" => $org
                        ];
                    }
                }                
            }else{
                $json_return = [
                    "status"     => "ERROR",
                    "message"    => "Email Not Found",
                    "alert"      => "alert alert-danger",
                    "code"       => 000,
                    "additional" => ""
                ];
            }
        }else{
            $json_return = [
                "status"     => "ERROR",
                "message"    => "Please enter the valid email address",
                "alert"      => "alert alert-danger",
                "code"       => 010,
                "additional" => ""
            ];
        }
        echo json_encode($json_return);
        die();
    }

    public function checkEmailAdd(){
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $get   = $this->input->get();
        $owner = ($this->data['user']->owner_id)?$this->data['user']->owner_id:$this->data['user']->id;
        
        $email = $get['email'];
        $validation = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!empty($validation)) {
            $checkEmailUser = $this->M_user->checkEmailUser2($email);
            if (empty($checkEmailUser)) {
                $json_return = [
                    "status"     => "OK",
                    "message"    => "<i class='fa fa-check'></i> Email Available, you can use this email.",
                    "alert"      => "alert alert-success",
                    "code"       => 000,
                    "additional" => ""
                ]; 
            }else{
                if ($checkEmailUser->owner_id == $owner) {
                    $link_edit = base_url('edit-user?parameter='.encode($checkEmailUser->id));
                    $json_return = [
                        "status"     => "ERROR",
                        "message"    => "<i class='fa fa-exclamation-triangle'></i> This email already registered as your member. <a href='".$link_edit."'>CLICK HERE</a> To Edit Access<br>or <a href='javascript:void(0);' id='sendInvite'>CLICK HERE</a> to Send Invitation Link.",
                        "alert"      => "alert alert-warning",
                        "code"       => 001,
                        "additional" => ""
                    ];
                }else{
                    $checkInvited = $this->M_user->check_member_invitation_id_available($checkEmailUser->id, $owner);
                    if (empty($checkInvited)) {
                        $json_return = [
                            "status"     => "ERROR",
                            "message"    => "<i class='fa fa-exclamation-triangle'></i> This email already registered as part of other organization. <a href='javascript:void(0);' id='sendInvite'>CLICK HERE</a> To send invitation.!",
                            "alert"      => "alert alert-warning",
                            "code"       => 001,
                            "additional" => ""
                        ];
                    }else{
                        $link_edit = base_url('edit-user?parameter='.encode("invited-".$checkEmailUser->id));
                        $json_return = [
                            "status"     => "ERROR",
                            "message"    => "<i class='fa fa-exclamation-triangle'></i> This email is already invited as your member. <a href='".$link_edit."'>CLICK HERE</a> To Edit Access.",
                            "alert"      => "alert alert-warning",
                            "code"       => 001,
                            "additional" => ""
                        ];
                    }
                }
            }
        }else{
            $json_return = [
                "status"     => "ERROR",
                "message"    => "<i class='fa fa-times'></i> Please enter the valid email address",
                "alert"      => "alert alert-danger",
                "code"       => 010,
                "additional" => ""
            ];
        }
        echo json_encode($json_return);
        die();
    }

    public function sendInvitation(){
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $post = $this->input->post();
        if (isset($post['organization'])) {
            $owner       = ($this->data['user']->owner_id)?$this->data['user']->owner_id:$this->data['user']->id;
            $member      = $this->M_user->checkEmailUser2($post['email_invitation']);
            $idnya       = 0;
            $member_type = "self";
            $role        = "user";

            if ($owner != $member->owner_id) {
                $member_type          = "other";
                $checkEmailActivation = $this->M_user->check_member_invitation($post['email_invitation'], $owner);

                $duration_expired = date("Y-m-d", strtotime("+1 days"));
                $insertArray = [
                    "email"        => $post['email_invitation'],
                    "role"         => $role,
                    "exp_date"     => $duration_expired,
                    "invited_by"   => $this->data['user']->id,
                    "invited_date" => date("Y-m-d H:i:s"),
                    "owner_id"     => $owner,
                    "member_id"    => $member->id,
                    "status"       => 0
                ];
                if (empty($checkEmailActivation)) {
                    $this->db->insert("member_invitation", $insertArray);
                    $idnya = $this->db->insert_id();
                }else{
                    /*if ($checkEmailActivation->status == 0 AND $checkEmailActivation->exp_date < date("Y-m-d")) {
                        $json_return = [
                            "status" => "FAILED",
                            "message"   => "Already sent invitation for this email, Expirate date will be "
                        ];
                        return 
                    }*/
                    $idnya = $checkEmailActivation->id;
                    $this->db->update("member_invitation", $insertArray, ['id' => $idnya]);
                }

                $next_url = base_url('edit-user?parameter='.encode("invited-".$member->id));
            }else{
                $next_url = base_url('edit-user?parameter='.encode($member->id));
                $member_type = "self";
            }
            

            foreach ($post['organization'] as $okey => $ovalue) {
                $check_member_org = $this->M_user->check_invite_org($ovalue, $member->id);
                if (empty($check_member_org)) {
                    $this->db->insert("organization_members", 
                        ["organization" => $ovalue, "member" => $member->id, "role" => "user", "invitation_id" => $idnya]
                    );
                }
            }

            $email_validation = [
                "email"         => $post['email_invitation'],
                "role"          => $role,
                "invitation_id" => $idnya,
                "member_type"   => $member_type
            ];

            $link = encode(json_encode($email_validation));
            $link = base_urL('validationemail?validate='.$link);

            $data['link']       = $link;
            $data['owner_name'] = $this->M_user->getMemberName($owner);
            // SEND EMAIL INVITATION
            $template = $this->load->view("email_form", $data, true);
            $this->send_email("noreplay@aa.com", "aaa", $post['email_invitation'], [], "Invitation Organization", $template);

            $json_return = [
                "status"   => "OK",
                "message"  => "Invitation success to email ".$post['email_invitation'],
                "next_url" => $next_url
            ];
        }else{
            $json_return = [
                "status"  => "FAILED",
                "message" => "Please choose Organization",
            ];
        }
        echo json_encode($json_return);
        die();
    }

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
                'smtp_user'    => "myemailtempyf@gmail.com",
                'smtp_pass'    => "Yulia098!@#",
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


    public function doRevoke(){
        $get = $this->input->get();
        if (empty($get)) {
            redirect('');
        }

        $owner = $this->data['user']->owner_id;
        if ($owner == "") {
            $owner = $this->data['user']->id;
        }

        $decode        = decode($get['parameter']);
        $doExplode     = explode("-", $decode);
        $invitation_id = $doExplode[1];
        $member_id     = $doExplode[2];

        $listOrg = $this->M_user->getOrganizationByOwner($owner);
        $org     = [];
        foreach ($listOrg as $key => $value) {
            $this->db->delete("organization_members",["organization" => $value->id, "member" => $member_id, "invitation_id" => $invitation_id]);
            $this->db->delete("member_module", ["member_id" => $member_id, "organization" => $value->id]);
            $this->db->delete("member_module_sub", ["member_id" => $member_id, "organization" => $value->id]);
            $org[] = $value->id;
        }
        
        $this->db->update("member_invitation", ["status" => 2], ['id' => $invitation_id]);

        $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">Revoke user success</div>');
        redirect('user');
    }
}
