<?php

class Stock_opname_share extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }
    function detail_pdf($encrypted_id)
    {

        if (empty($encrypted_id)) {
            show_error("ID Kosong");
        }
        $id_stock_opname = decode_key($encrypted_id);

        $this->load->model('Stock_opname_model');
        $this->load->model('Stock_opname_detail_model');

        $stock_opname_model = new Stock_opname_model();
        $stock_opname_detail_model = new Stock_opname_detail_model();

        $content_data = array();
        $content_data['id_stock_opname'] = $id_stock_opname;
        $content_data['stock_opname'] = $stock_opname_model->detail($id_stock_opname);
        $content_data['stock_opname_detail'] = $stock_opname_detail_model->detail($id_stock_opname);

        $content = $this->load->view('stock_opname/stock_opname_detail_pdf', $content_data, true);

        // echo $content;
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
        $html2pdf->writeHTML($content);
        $html2pdf->output();
    }

}