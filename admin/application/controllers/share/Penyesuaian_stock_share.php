<?php

class Penyesuaian_stock_share extends CI_Controller
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
        $id_penyesuaian_stock = decode_key($encrypted_id);

        $this->load->model('Penyesuaian_stock_model');
        $this->load->model('Penyesuaian_stock_detail_model');
        $penyesuaian_stock_model = new Penyesuaian_stock_model();
        $penyesuaian_stock_detail_model = new Penyesuaian_stock_detail_model();


        $content_data = array();
        $content_data = array();
        $content_data['id_penyesuaian_stock'] = $id_penyesuaian_stock;
        $content_data['penyesuaian_stock'] = $penyesuaian_stock_model->detail($id_penyesuaian_stock);
        $content_data['penyesuaian_stock_detail'] = $penyesuaian_stock_detail_model->detail($id_penyesuaian_stock);


        $content = $this->load->view('penyesuaian_stock/penyesuaian_stock_detail_pdf', $content_data, true);

        // echo $content;
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A5', 'en');
        $html2pdf->writeHTML($content);
        $html2pdf->output();
    }

}
