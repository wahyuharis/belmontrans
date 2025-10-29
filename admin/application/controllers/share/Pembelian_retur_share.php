<?php

class Pembelian_retur_share extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }
    function detail_pdf($encrypted_id){

        if(empty($encrypted_id)){
            show_error("ID Kosong");
        }
        $id_pembelian_retur=decode_key($encrypted_id);

        $this->load->model('Pembelian_retur_model');
        $this->load->model('Pembelian_retur_detail_model');
        $this->load->model('Pembelian_retur_biaya_model');
        $pembelian_retur_model = new Pembelian_retur_model();
        $pembelian_retur_detail_model = new Pembelian_retur_detail_model();
        $pembelian_retur_biaya_model = new Pembelian_retur_biaya_model();


        $content_data = array();
        $content_data['id_pembelian_retur'] = $id_pembelian_retur;
        $content_data['pembelian_retur'] = $pembelian_retur_model->detail($id_pembelian_retur);
        $content_data['pembelian_retur_detail'] = $pembelian_retur_detail_model->detail($id_pembelian_retur);
        $content_data['pembelian_retur_biaya'] = $pembelian_retur_biaya_model->detail($id_pembelian_retur);


        $content = $this->load->view('pembelian_retur/pembelian_retur_detail_pdf', $content_data, true);
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A5', 'en');
        $html2pdf->writeHTML($content);
        $html2pdf->output();
    }

    function history_pembayaran_pdf($id_pembelian_retur = null)
    {
        if (empty(trim($id_pembelian_retur))) {
            show_error("ID Kosong");
        }

        $id_pembelian_retur=decode_key($id_pembelian_retur);

        $this->load->model('Pembelian_retur_model');
        $pembelian_retur_model = new Pembelian_retur_model();

        $this->load->model('Pembelian_retur_bayar_model');
        $pembelian_retur_bayar_model = new Pembelian_retur_bayar_model();

        
        $content_data = array();
        $content_data['id_pembelian_retur'] = $id_pembelian_retur;
        $content_data['pembelian_retur'] = $pembelian_retur_model->detail($id_pembelian_retur);
        $content_data['pembelian_retur_bayar'] = $pembelian_retur_bayar_model->get_list($id_pembelian_retur);
        $content_data['encrypted_id'] = encode_key($id_pembelian_retur);

        // print_r2($content_data['pembelian_retur_bayar']);

        $content = $this->load->view('pembelian_retur/pembelian_retur_history_pembayaran_pdf', $content_data, true);
        // echo $content;
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A5', 'en');
        $html2pdf->writeHTML($content);
        $html2pdf->output();
    }
}