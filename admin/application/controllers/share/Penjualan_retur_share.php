<?php

class Penjualan_retur_share extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }
    function detail_pdf($encrypted_id){

        if(empty($encrypted_id)){
            show_error("ID Kosong");
        }
        $id_penjualan_retur=decode_key($encrypted_id);

        $this->load->model('Penjualan_retur_model');
        $this->load->model('Penjualan_retur_detail_model');
        $this->load->model('Penjualan_retur_biaya_model');
        $penjualan_retur_model = new Penjualan_retur_model();
        $penjualan_retur_detail_model = new Penjualan_retur_detail_model();
        $penjualan_retur_biaya_model = new Penjualan_retur_biaya_model();


        $content_data = array();
        $content_data['id_pembelian_retur'] = $id_penjualan_retur;
        $content_data['penjualan_retur'] = $penjualan_retur_model->detail($id_penjualan_retur);
        $content_data['penjualan_retur_detail'] = $penjualan_retur_detail_model->detail($id_penjualan_retur);
        $content_data['penjualan_retur_biaya'] = $penjualan_retur_biaya_model->detail($id_penjualan_retur);

        // print_r2($content_data);


        $content = $this->load->view('penjualan_retur/penjualan_retur_detail_pdf', $content_data, true);
        // echo $content;
        // die();
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A5', 'en');
        $html2pdf->writeHTML($content);
        $html2pdf->output();
    }

    function history_pembayaran_pdf($id_penjualan_retur = null)
    {
        if (empty($id_penjualan_retur)) {
            show_error("ID Kosong");
        }

        $id_penjualan_retur=decode_key($id_penjualan_retur);

        $this->load->model('Penjualan_retur_model');
        $penjualan_retur_model = new Penjualan_retur_model();

        $this->load->model('Penjualan_retur_bayar_model');
        $penjualan_retur_bayar_model = new Penjualan_retur_bayar_model();

        
        $content_data = array();
        $content_data['id_pembelian_retur'] = $id_penjualan_retur;
        $content_data['penjualan_retur'] = $penjualan_retur_model->detail($id_penjualan_retur);
        $content_data['penjualan_retur_bayar'] = $penjualan_retur_bayar_model->get_list($id_penjualan_retur);

        $content = $this->load->view('penjualan_retur/penjualan_retur_history_pembayaran_pdf', $content_data, true);
        // echo $content;
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A5', 'en');
        $html2pdf->writeHTML($content);
        $html2pdf->output();
    }
}