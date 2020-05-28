<?php

defined('BASEPATH') or exit('No direct script access allowed!');

require '../vendor/autoload.php';

use Mpdf\Mpdf;

class Pdf extends CI_Controller
{

    public $data = [];
    public function __construct()
    {
        parent::__construct();
    }

    public function invoice($type, $id, $org, $download = 0)
    {
        $id  = decode($id);
        $org = decode($org);

        $this->data['org'] = $this->db->get_where('organizations', ['id' => $org])->result()[0];

        $this->data['data'] = $this->main->get(
            'sales',
            [
                'type' => $type, 'is_deleted' => 0,
                'id' => $id,
                'organization' => $org
            ]
        );
        if (!$this->data['data']) {
            exit();
        }
        $template_options = 'template_sale_' . $type . '_options';

        $this->data['template']   = json_decode($this->data['org']->{$template_options});
        $this->data['signatures'] = json_decode($this->data['org']->signatures, true);
        $this->lang->load('invoices');
        $this->load->model('invoices_model');
        $this->data['products'] = $this->main->gets('sale_products', ['sale' => $this->data['data']->id]);

        $this->data['taxes']        = $this->invoices_model->get_taxes($this->data['data']->id);
        $this->data['charges_fees'] = $this->invoices_model->get_charges_fees($this->data['data']->id);

        $stylesheet = file_get_contents('assets/css/invoice_default.css');

        $getCode = $this->db->select("code")
            ->from("contacts")
            ->where("id", $this->data['data']->customer);
        $getCode = $this->db->get()->row()->code;

        $cust_code = "";
        if ($getCode != "") {
            $cust_code = "-".$getCode;
        }

        $exp_code = explode("/", $this->data['data']->code);
        $nameSave = $exp_code[0].$cust_code."-".$exp_code[1]."_".$exp_code[2]."-".str_replace(" ","_",$this->data['data']->subject);
        // $nameSave = str_replace(array("/", " "), array("-", "_"), $this->data['data']->code."-".$this->data['data']->subject.$cust_code);
        $this->data['namesave'] = $nameSave;

        // $html = $this->load->view('sale_' . $type, $this->data, true);
        $html = $this->load->view('sale/invoice_default2', $this->data, true);
        // die($html);
        $mpdf = new Mpdf();
        $mpdf->SetTitle($nameSave);
        $mpdf->useFixedNormalLineHeight = false;
        $mpdf->useFixedTextBaseline = false;
        $mpdf->adjustFontDescLineheight = 0.5;
        $mpdf->writeHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html);

        if ($download) {
            $mpdf->Output($nameSave . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
        } else {
            $mpdf->Output($nameSave.".pdf", 'I');
        }
    }

    public function invoice_child($type, $id, $org, $download = 0)
    {
        $id = decode($id);
        $org = decode($org);
        $this->data['invoice_child'] = $this->main->get('sales_invoice_child', ['id' => $id]);
        $this->data['org'] = $this->db->get_where('organizations', ['id' => $org])->row();

        $this->data['data'] = $this->main->get('sales', ['type' => 'invoice', 'is_deleted' => 0, 'id' => $this->data['invoice_child']->sale, 'organization' => $org]);
        if (!$this->data['data']) {
            exit();
        }

        $template_options = 'template_sale_' . $type . '_options';
        $this->data['template'] = json_decode($this->data['org']->{$template_options});
        $this->data['signatures'] = json_decode($this->data['org']->signatures, true);
        $this->lang->load('invoices');
        $this->load->model('invoices_model');
        $this->data['products'] = $this->main->gets('sale_products', ['sale' => $this->data['data']->id]);
        $this->data['taxes'] = $this->invoices_model->get_taxes($this->data['data']->id);
        $this->data['charges_fees'] = $this->invoices_model->get_charges_fees($this->data['data']->id);
        $html = $this->load->view('sale_' . $type . '_child', $this->data, true);

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        if ($download) {
            $mpdf->Output(encode($this->data['data']->id) . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
        } else {
            $mpdf->Output();
        }
    }
}
