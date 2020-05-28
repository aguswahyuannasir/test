<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Invoices_child extends CI_Controller
{

    public function index($id)
    {
        $id = decode($id);

        $this->data['invoice_child'] = $this->main->get('sales_invoice_child', ['id' => $id]);
        $this->data['data'] = $this->main->get(
            'sales',
            [
                'type' => 'invoice', 'is_deleted' => 0,
                'id' => $this->data['invoice_child']->sale
            ]
        );
        if (!$this->data['data']) {
            exit();
        }
        $this->data['org'] = $this->main->get('organizations', ['id' => $this->data['data']->organization]);
        $this->data['org']->image = '../' . $this->data['org']->image;
        $template_options = 'template_sale_invoice_options';

        $this->data['template'] = json_decode($this->data['org']->{$template_options});
        $this->data['signatures'] = json_decode($this->data['org']->signatures, true);
        $this->lang->load('invoices');
        $this->load->model('invoices_model');
        $this->data['products'] = $this->main->gets('sale_products', ['sale' => $this->data['data']->id]);

        $this->data['taxes'] = $this->invoices_model->get_taxes($this->data['data']->id);
        $this->data['charges_fees'] = $this->invoices_model->get_charges_fees($this->data['data']->id);

        $this->template->_init();
        $this->output->set_title($this->data['invoice_child']->code . '.pdf');
        $this->load->js('assets/js/modules/customer.js');
        $this->load->css('assets/css/invoice_default.css');
        // $this->load->css('assets/css/customer_view.css');
        // $this->load->view('invoice_child', $this->data);
        $this->load->view('sale/invoice_default', $this->data);
    }
}
