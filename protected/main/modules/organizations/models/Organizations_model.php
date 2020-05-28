<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Organizations_model extends CI_Model {

    function get_all($member,$filter_organization=NULL) {
        $this->db->select('a.organization, a.role,b.id, b.name organization_name,c.package_name,b.status organization_status,b.start_from,b.valid_until,b.package, a.invitation_id')
                ->join('organizations b','a.organization = b.id','left')
                ->join('packages c','c.package_id = b.package','left')
                ->where('a.member',$member)
                ->where('b.is_deleted',0);
        if($filter_organization){
            $this->db->where_in('a.organization',$filter_organization); 
        }
        $query = $this->db->get('organization_members a');
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    function get_organizations() {
        $this->db->select('a.id,a.name');
        $this->db->where('a.is_deleted',0);
        $query = $this->db->get('organizations a');
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    function get_members() {
        $this->db->select('a.id,a.fullname');
        $query = $this->db->get('members a');
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    function get_packages() {
        $this->db->select('a.package_id,a.package_name,price');
        $this->db->where('status',1);
        $query = $this->db->get('packages a');
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }
    function get_companyList($id) {
        $this->db->select('a.organization as id');
        if($id) {
            $this->db->where('a.member',$id);
        }
        $query = $this->db->get('organization_members a');
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }
    function get_members_2($id) {
        $this->db->select('b.id,b.fullname');
        if($id) {
            $this->db->where('a.organization',$id);
        }
        $this->db->where('a.role','owner');
        $this->db->group_by('b.id');
        $this->db->join('members b','b.id = a.member','left');
        $query = $this->db->get('organization_members a');
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    function get_companyList2($id){

    }
    function get_list_data($param = array(),$method="default",$addtional=""){
        $start  = $param['start'];
        $length = $param['length'];
        
        $columns    = array(
            1 => 'org.name',
            2 => '`date`',
            3 => '`sl`.`status`',
            4 => 'customer_name',
            5 => 'subject',
            6 => '`date`',
            7 => 'subtotal',
            8 => 'total'
        );

        if ($addtional<> "") {
            $sql = "SELECT
               COUNT(*) as total_data
            FROM sales AS sl
            INNER JOIN organizations AS org ON org.id = sl.organization
            ";
        }else{
            $sql = "SELECT
                sl.id,
                sl.organization,
                sl.type,
                sl.subject,
                sl.code,
                sl.customer_name,
                `sl`.`date`,
                sl.due_date,
                sl.subtotal,
                sl.total_charges_fee,
                sl.total_tax,
                sl.total,
                sl.date_added,
                `sl`.`status`,
                org.name,
                sl.currency_prefix
            FROM sales AS sl
            INNER JOIN organizations AS org ON org.id = sl.organization
            ";
        }
        

        $where   = "";
        $orderby = " ";
        
        $where.=" WHERE sl.is_deleted <> 1 AND type='invoice'";

        if ($param['organizations'] == 0 AND $param['allORG'] <> "") {
            $oFilter = explode(",", $param['allORG']);
            $where.=" AND ( ";
            foreach ($oFilter as $ofkey => $ofvalue) {
                $oFilter[$ofkey] =  "sl.organization = ".$ofvalue;
            }
            $where.= implode(" or ",$oFilter);
            $where.= " )";
        }elseif($param['organizations'] != 0){
            $where.=" AND sl.organization = ".$param['organizations'];
        }

        if (isset($param['range'])) {
            $explodeRange = explode(" - ", $param['range']);

            $startRange = date("Y-m-d", strtotime($explodeRange[0]));
            $endRange   = date("Y-m-d", strtotime($explodeRange[1]));

            $where.=" AND (`sl`.`date` BETWEEN '".$startRange."' AND '".$endRange."')";
        }

        // $where.=" AND YEAR(`sl`.`date`) = '".$param['year']."'";
        // $where.=" AND MONTH(`sl`.`date`) = '".$param['month']."'";

        if(!empty($param['search']['value'])){ 
            if($where != ""){
                $where.= " AND ";
            }else{
                $where.= " WHERE ";
            }
            
            /*$where.= " (member_first_name like '%".$param['search']['value']."%' ";
            $where.= " or member_last_name like '%".$param['search']['value']."%' ";
            $where.= " or member_email like '%".$param['search']['value']."%' ";
            $where.= " or member_phone like '%".$param['search']['value']."%' ";
            $where.= " or rekening like '%".$param['search']['value']."%' ";
            $where.= " ) ";*/
        }

        if(!empty($param['order'][0]['column'])){
            $orderby.=" ORDER BY ".$columns[$param['order'][0]['column']]." ".$param['order'][0]['dir']." ";        
        }else{
            $orderby.=" ORDER BY sl.`date` DESC";
        }

        if($addtional == ""){
            if($param['length'] == '-1'){
                $orderby.="";
            }else{
                $orderby.="  LIMIT ".$start." ,".$length." ";
            }
        } 

        $sql.=$where.$orderby;
        $query = $this->db->query($sql);
        return $query;
    }

    function getMoreInfo($id){
        $sql = "SELECT
                sl.id,
                sl.organization,
                sl.type,
                sl.subject,
                sl.code,
                sl.customer_name,
                `sl`.`date`,
                sl.due_date,
                sl.subtotal,
                sl.total_charges_fee,
                sl.total_tax,
                sl.total,
                sl.date_added,
                `sl`.`status`,
                org.name,
                sl.currency_prefix,
                sl.brand,
                sl.project,
                sl.project_description,
                sl.paid_date,
                sl.paid_payment_method,
                sl.paid_master_account,
                sl.paid_acc_name,
                sl.paid_amount,
                sl.customer_received_date
            FROM sales AS sl
            INNER JOIN organizations AS org ON org.id = sl.organization WHERE sl.id = ".$id;

        $query  = $this->db->query($sql);
        return $query->row();
    }

    function getDataPPn($sale_id){
        $this->db->select("SUM(spt.tax_rate) AS total_tax_rate, SUM(spt.tax_amount) AS total_tax_amount");
        $this->db->from("sale_product_taxes AS spt");
        $this->db->join("sale_products AS sp","sp.id = spt.sale_product");
        $this->db->where("sp.sale", $sale_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    function sum_invoice_current($year, $organization = array()){
        $this->db->select("SUM(total) AS current")
            ->from("sales")
            ->where("type", 'invoice')
            ->where("status", 'paid')
            ->where("YEAR(paid_date)", $year);
        $where = [];
        foreach ($organization as $key => $value) {
            $where[] = "organization =".$value;
        }
        if (!empty($where)) {
            $im_wh = implode(" OR ", $where);
            $this->db->where("(".$im_wh.")");
        }
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    function sum_current_sub($year, $organization = array()){
        $this->db->select("SUM(sic.payment_amount) AS current_sub")
            ->from("sales_invoice_child AS sic")
            ->join("sales AS sl", 'sl.id = sic.sale')
            ->where("sic.status", 'paid')
            ->where("sl.status !=", 'paid')
            ->where("sl.type", "invoice")
            ->where("YEAR(sic.pay_date)", $year);
        $where = [];
        foreach ($organization as $key => $value) {
            $where[] = "sl.organization =".$value;
        }
        if (!empty($where)) {
            $im_wh = implode(" OR ", $where);
            $this->db->where("(".$im_wh.")");
        }
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    function sum_invoice_draft($year, $organization = []){
        $this->db->select("SUM(total) AS current")
            ->from("sales")
            ->where("type", 'invoice')
            ->where("status", 'draft')
            ->where("YEAR(date)", $year);
        $where = [];
        foreach ($organization as $key => $value) {
            $where[] = "organization =".$value;
        }
        if (!empty($where)) {
            $im_wh = implode(" OR ", $where);
            $this->db->where("(".$im_wh.")");
        }
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    function sum_overdue($time, $organization){
        $this->db->select("SUM(total) AS sums")
            ->from("sales")
            ->where("status", 'open')
            ->where("type",'invoice');
        $where = [];
        foreach ($organization as $key => $value) {
            $where[] = "organization =".$value;
        }
        if (!empty($where)) {
            $im_wh = implode(" OR ", $where);
            $this->db->where("(".$im_wh.")");
        }

        if ($time['type'] == "BETWEEN") {
            $this->db->where("`due_date` BETWEEN '".$time['start']."' AND '".$time['end']."'");
        }elseif($time['type'] == "BELOW"){
            $this->db->where("`due_date` <= '".$time['start']."'");
        }
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function check_invitation($organization, $member_id, $invitation_id){
        $this->db->select("mi.*")
            ->from("member_invitation AS mi")
            ->join("organization_members AS om", "om.invitation_id = mi.id")
            ->where("mi.member_id", $member_id)
            ->where("om.organization", $organization)
            ->where("mi.id", $invitation_id);
        $query  = $this->db->get();
        $result = $query->row();
        return $result;
    }
}
