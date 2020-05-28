<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Invoices_model extends CI_Model
{

    function __construct()
    {
        $this->columns = isset($this->data['table']) ? $this->data['table']['columns'] : [];
    }

    function get_taxes($sale)
    {
        $this->db->select('ptax.tax, ptax.tax_name name, ptax.tax_rate rate, SUM(ptax.tax_amount) amount, tx.is_ppn')
            ->join("taxes AS tx",'tx.id = ptax.tax')
            ->where_in('sale_product', 'SELECT id FROM sale_products WHERE sale = ' . $sale, false)
            ->group_by('tax');
        return $this->db->get('sale_product_taxes AS ptax');
    }

    function get_charges_fees($sale)
    {
        $this->db->select('charges_fee, charges_fee_name name, charges_fee_value value, SUM(charges_fee_amount) amount')
            ->where_in('sale_product', 'SELECT id FROM sale_products WHERE sale = ' . $sale, false)
            ->group_by('charges_fee');
        return $this->db->get('sale_product_charges_fees');
    }
}
