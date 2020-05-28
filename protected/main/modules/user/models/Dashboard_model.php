<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    function total_cycle_status($status) {
        $month = date('m');
        $year = date('Y');
        $this->db->select("IFNULL(SUM(CASE WHEN status = '" . $status . "' THEN 1 ELSE 0 END),0) total")
                ->join('delivery_cycle_path dcp', "dc.id = dcp.child AND (dcp.type ='AMBIL-DROP' OR dcp.type = 'DROP')", 'left')
                ->join('delivery_checksheet dcs', 'dcs.start_cycle = dcp.parent')
                ->join('deliveries d', 'dc.delivery = d.id', 'left')
                ->where(array('MONTH(d.date)' => $month, 'YEAR(d.date)' => $year));
        return $this->db->get('delivery_cycle dc')->row()->total;
    }

    function daily_cycle_status($year, $month) {
        $this->db->select("IFNULL(SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END),0) completed, 
                            IFNULL(SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END),0) pending, 
                            IFNULL(SUM(CASE WHEN status = 'on progress' THEN 1 ELSE 0 END),0) progress,
                            IFNULL(SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END),0) delivered,
                            IFNULL(SUM(CASE WHEN status = 'planning' THEN 1 ELSE 0 END),0) planning,
                            DAY(d.date) date")
                ->join('delivery_cycle_path dcp', "dc.id = dcp.child AND (dcp.type = 'AMBIL-DROP' OR dcp.type='DROP')", 'left')
                ->join('delivery_checksheet dcs', 'dcs.start_cycle = dcp.parent', 'left')
                ->join('deliveries d', 'dc.delivery = d.id', 'left')
                ->where(array('MONTH(d.date)' => $month, 'YEAR(d.date)' => $year))
                ->group_by('d.date');
        return $this->db->get('delivery_cycle dc');
    }

    function customer_cycle($year, $month) {
        $this->db->select("c.id, c.code, c.official_name name, IFNULL(SUM(dc.delivered),0) delivered, IFNULL(SUM(dc.cycle),0) cycle")
                ->join("(SELECT IFNULL(SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END),0) delivered, COUNT(dc.id) cycle, d.customer
                        FROM delivery_cycle dc
                        LEFT JOIN delivery_cycle_path dcp ON dc.id = dcp.child AND (dcp.type = 'AMBIL-DROP' OR dcp.type='DROP')
                        LEFT JOIN delivery_checksheet dcs ON dcs.start_cycle = dcp.parent
                        LEFT JOIN deliveries d ON dc.delivery = d.id
                        WHERE MONTH(d.date) = $month AND YEAR(d.date) = $year
                        GROUP BY d.customer) dc",'dc.customer = c.id OR dc.customer IN (SELECT id FROM customers WHERE is_branch = c.id)','left',false)
                ->where('c.is_branch',0)
                ->where('c.is_deleted',0)
                ->group_by('c.id');
        return $this->db->get('customers c');
    }

}
