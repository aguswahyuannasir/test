<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales_model extends CI_Model {

    function actual_plan($data) {
        if ($data['type'] == 'current_month') {
            $this->db->where('YEAR(d.date)', date('Y'));
            $this->db->where('MONTH(d.date)', date('m'));
        } elseif ($data['type'] == 'current_year') {
            $this->db->where('YEAR(d.date)', date('Y'));
        } elseif ($data['type'] == 'range') {
            $this->db->group_start()
                    ->where("d.date BETWEEN '$data[start]' AND '$data[end]'")
                    ->group_end();
        }

        $this->db->select("IFNULL(SUM(CASE WHEN status = 'delivered' THEN d.price ELSE 0 END),0) actual, IFNULL(SUM(d.price),0) plan")
                ->join('delivery_cycle_path dcp', "dc.id = dcp.child AND (dcp.type ='AMBIL-DROP' OR dcp.type = 'DROP')", 'left')
                ->join('delivery_checksheet dcs', 'dcs.start_cycle = dcp.parent')
                ->join('deliveries d', 'dc.delivery = d.id', 'left')
                ->where('dc.is_fake', 0)
                ->where('dc.is_cancel', 0);
        return $this->db->get('delivery_cycle dc')->row();
    }

}
