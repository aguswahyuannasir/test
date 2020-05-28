<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Model {

    function gets($table, $conditions = array(), $order = NULL, $group = NULL, $limit=NULL) {
        if ($order) {
            $this->db->order_by($order);
        }
        if ($group) {
            $this->db->group_by($group);
        }
        if ($limit) {
            $this->db->limit($limit);
        }
        if (count($conditions) > 0) {
            $query = $this->db->get_where($table, $conditions);
        } else {
            $query = $this->db->get($table);
        }
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function gets_paging($table, $from, $max, $condition = array(), $sort, $order) {
        if ($condition) {
            $this->db->where($condition);
        }
        if ($sort && $order) {
            $this->db->order_by($sort, $order);
        }
        $this->db->limit($max, $from);
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query : false;
    }

    function get($table, $conditions = array()) {
        $query = $this->db->get_where($table, $conditions);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function insert($table, $data = array()) {
        $query = $this->db->insert($table, $data);
        return ($query) ? $this->db->insert_id() : false;
    }

    function replace($table, $data = array()) {
        $query = $this->db->replace($table, $data);
        return ($query) ? true : false;
    }

    function update($table, $data = array(), $condition = array()) {
        $this->db->where($condition);
        return $this->db->update($table, $data);
    }

    function delete($table, $condition = array()) {
        $this->db->where($condition);
        $this->db->delete($table);
        return($this->db->affected_rows() > 0) ? true : false;
    }

    function count($table, $condition = array()) {
        if ($condition) {
            $this->db->where($condition);
        }
        return $this->db->count_all_results($table);
    }

    function truncate($table) {
        $query = $this->db->truncate($table);
        return($query) ? true : false;
    }
    
    function customers(){
        return $this->db->query("SELECT * FROM (SELECT id, code, name, official_name FROM customers
                        WHERE is_branch = 0 AND is_deleted = 0
                        UNION
                        SELECT c1.id, c1.code, CONCAT(c2.name,':: ',c1.name) name, c2.official_name FROM customers c1
                        LEFT JOIN customers c2 ON c2.id = c1.is_branch
                        WHERE c1.is_branch != 0 AND c1.is_deleted = 0) c ORDER BY name asc");
    }

}

/*============================================================================
#  _____  _  __ _Created By:_____       rifkysyaripudin@gmail.com    _ _       
# |  __ \(_)/ _| |         / ____|                (_)               | (_)      
# | |__) |_| |_| | ___   _| (___  _   _  __ _ _ __ _ _ __  _   _  __| |_ _ __  
# |  _  /| |  _| |/ / | | |\___ \| | | |/ _` | '__| | '_ \| | | |/ _` | | '_ \ 
# | | \ \| | | |   <| |_| |____) | |_| | (_| | |  | | |_) | |_| | (_| | | | | |
# |_|  \_\_|_| |_|\_\\__, |_____/ \__, |\__,_|_|  |_| .__/ \__,_|\__,_|_|_| |_|
#                     __/ |        __/ |            | |                        
#                    |___/        |___/             |_|                        
=============================================================================*/