<?php

class Penjualan_share extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }
    function detail_pdf($encrypted_id){

        if(empty($encrypted_id)){
            show_error("ID Kosong");
        }
        $id_penjualan=decode_key($encrypted_id);

        $this->load->model('Penjualan_model');
        $this->load->model('Penjualan_detail_model');
        $this->load->model('Penjualan_biaya_model');
        $penjualan_model = new Penjualan_model();
        $penjualan_detail_model = new Penjualan_detail_model();
        $penjualan_biaya_model = new Penjualan_biaya_model();


        $content_data = array();
        $content_data['id_penjualan'] = $id_penjualan;
        $content_data['penjualan'] = $penjualan_model->detail($id_penjualan);
        $content_data['penjualan_detil'] = $penjualan_detail_model->detail($id_penjualan);
        $content_data['penjualan_biaya'] = $penjualan_biaya_model->detail($id_penjualan);


        $content = $this->load->view('penjualan/penjualan_detail_pdf', $content_data, true);

        // echo $content;
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A5', 'en');
        $html2pdf->writeHTML($content);
        $html2pdf->output();
    }
    function history_pembayaran_pdf($id_penjualan = null)
    {
        if (empty($id_penjualan)) {
            show_error("ID Kosong");
        }

        $id_penjualan=decode_key($id_penjualan);

        $this->load->model('Penjualan_model');
        $penjualan_model = new Penjualan_model();

        $this->load->model('Penjualan_bayar_model');
        $penjualan_bayar_model = new Penjualan_bayar_model();


        $content_data = array();
        $content_data['id_penjualan'] = $id_penjualan;
        $content_data['penjualan'] = $penjualan_model->detail($id_penjualan);
        $content_data['penjualan_bayar'] = $penjualan_bayar_model->get_list($id_penjualan);
        $content_data['encrypted_id'] = encode_key($id_penjualan);
        

        $content = $this->load->view('penjualan/penjualan_history_pembayaran_pdf', $content_data, true);
        // echo $content;
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A5', 'en');
        $html2pdf->writeHTML($content);
        $html2pdf->output();

    }
}