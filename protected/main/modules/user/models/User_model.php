<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    function getAllOrganization(){

    }

    function getOrganizationByOwner($member){
        $this->db->select("organization AS id, org.name")
            ->from("organization_members AS om")
            ->join("organizations AS org", "org.id = om.organization")
            ->where("om.member", $member)
            ->where("om.role","owner")
            ->where('org.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function getOrganizationByOwnerUser($member){
        $this->db->select("organization AS id, org.name, om.invitation_id, mi.status")
            ->from("organization_members AS om")
            ->join("organizations AS org", "org.id = om.organization")
            ->join("member_invitation AS mi","mi.id = om.invitation_id AND (mi.status != 0 AND mi.status != 2)" , "LEFT")
            ->where("om.member", $member)
            ->where('org.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getOrganizationByOwnerUserMember($owner, $member_exclude){
        $this->db->select("organization AS id, org.name, om.invitation_id, mi.status")
            ->from("organization_members AS om")
            ->join("organizations AS org", "org.id = om.organization")
            ->join("member_invitation AS mi","mi.id = om.invitation_id AND (mi.status != 0 AND mi.status != 2)" , "LEFT")
            ->where("om.member", $owner)
            ->where("om.member !=", $member_exclude)
            ->where('org.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getModule(){
        $this->db->select("id, module_name, is_parent")
            ->from("sys_module")
            ->where('is_deleted', 0)
            ->order_by('module_order', 'ASC');
        $query  = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getModuleSub($module_id){
        $this->db->select('id, sub_name, is_parent')
            ->from('sys_module_sub')
            ->where('is_deleted', 0)
            ->where('module_id', $module_id)
            ->where('( parent_id IS NULL OR parent_id = "" )')
            ->order_by('sub_order', 'ASC');
        $query  = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getModuleSubChild($parent){
        $this->db->select('id, sub_name')
            ->from('sys_module_sub')
            ->where('is_deleted', 0)
            ->where('parent_id', $parent)
            ->order_by('sub_order', 'ASC');
        $query  = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function checkEmailUser($email){
        $this->db->select("COUNT(*) AS num")
            ->from("members")
            ->where("email", $email)
            ->where("is_deleted !=",1);
        $query  = $this->db->get();
        $result = $query->row()->num;
        return $result;
    }

    public function checkEmailUser2($email){
        $this->db->select("mb.id, mb.email, mb.fullname, org.name AS organization_name, mb.owner_id")
            ->from("members AS mb")
            ->join("organization_members AS om", 'om.member = mb.id', "LEFT")
            ->join("organizations AS org","org.id = om.organization AND org.is_deleted != 1", "LEFT")
            ->where("mb.email", $email)
            ->where("mb.is_deleted !=",1);
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function listUserOwner($owner_id){
        $this->db->select("id, email, banned, fullname, owner_id")
            ->from("members")
            ->where('is_deleted !=', 1)
            ->where("owner_id", $owner_id);
        $query  = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getUserDetail($user){
        $this->db->select("*")
            ->from("members")
            ->where("id", $user);
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getModuleListInstalled($user, $organization = []){
        $this->db->select("*")
            ->from("member_module")
            ->where("member_id", $user);
        if (!empty($organization)) {
            $sql = [];
            foreach ($organization as $key => $value) {
                $sql[] = "organization = ".$value;
            }
            $this->db->where("(".implode(" or ", $sql).")");
        }
        // $this->db->group_by("module_id");
        $query  = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function listInstalledSub($user, $organization = []){
        $this->db->select("*")
            ->from("member_module_sub")
            ->where("member_id", $user);
        if (!empty($organization)) {
            $sql = [];
            foreach ($organization as $key => $value) {
                $sql[] = "organization = ".$value;
            }
            $this->db->where("(".implode(" or ", $sql).")");
        }
        // $this->db->group_by("module_sub_id");
        $query  = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function listInstalledOrg($user){
        $this->db->select("*")
            ->from("organization_members")
            ->where("member", $user);
        $query  = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function check_member_invitation($email, $owner_id){
        $this->db->select("*")
            ->from("member_invitation")
            ->where("email", $email)
            ->where("owner_id", $owner_id);
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function check_member_invitation_id_available($member_id, $owner_id){
        $this->db->select("*")
            ->from("member_invitation")
            ->where("member_id", $member_id)
            ->where("owner_id", $owner_id)
            ->where("status !=", 2);
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function check_invite_org($org, $member_id){
        $this->db->select("*")
            ->from("organization_members")
            ->where("organization", $org)
            ->where("member", $member_id);
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getInvitedMemberOwner($owner){
        $this->db->select("mi.id AS invitation_id, mi.member_id, mb.fullname, mb.email, mi.invited_date, mi.status, mi.owner_id")
            ->from("member_invitation AS mi")
            ->join("members AS mb", "mb.id = mi.member_id")
            ->where("mi.owner_id", $owner)
            ->where("(mi.status = 1 or mi.status = 0)");
        $query  = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getInvitedMember($member, $owner){
        $this->db->select("mi.*")
            ->from("member_invitation AS mi")
            ->join("members AS mb", "mb.id = mi.member_id")
            ->where("mi.member_id", $member)
            ->where("mi.owner_id", $owner)
            ->where("(mi.status = 1 or mi.status = 0)");
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getUserOwner($member_id){
        $this->db->select("owner_id")
            ->where("id", $member_id);
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function invitedOrg($member_id, $owner_id){
        $this->db->select("organization AS id, org.name")
            ->from("organization_members AS om")
            ->join("organizations AS org", "org.id = om.organization")
            ->join("member_invitation AS mi",'mi.member_id = om.member')
            ->where("om.member", $member_id)
            ->where("(om.invitation_id != 0 AND om.invitation_id IS NOT NULL)")
            ->where("mi.owner_id", $owner_id)
            ->where('org.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getMemberName($member_id){
        $this->db->select("fullname")
            ->from("members")
            ->where("id", $member_id);
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }
}
