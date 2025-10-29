<?php

class Pembelian_share extends CI_Controller
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
        $id_pembelian = decode_key($encrypted_id);

        $this->load->model('Pembelian_model');
        $this->load->model('Pembelian_detail_model');
        $this->load->model('Pembelian_biaya_model');
        $pembelian_model = new Pembelian_model();
        $pembelian_detil_model = new Pembelian_detail_model();
        $pembelian_biaya_model = new Pembelian_biaya_model();


        $content_data = array();
        $content_data['pembelian'] = $pembelian_model->detail($id_pembelian);
        $content_data['pembelian_detil'] = $pembelian_detil_model->detail($id_pembelian);
        $content_data['pembelian_biaya'] = $pembelian_biaya_model->detail($id_pembelian);

        // print_r2($content_data['pembelian']);


        $content = $this->load->view('pembelian/pembelian_detail_pdf', $content_data, true);
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A5', 'en');
        $html2pdf->writeHTML($content);
        $html2pdf->output();
    }
    function history_pembayaran_pdf($id_pembelian = null)
    {
        if (empty($id_pembelian)) {
            show_error("ID Kosong");
        }

        $id_pembelian = decode_key($id_pembelian);

        $this->load->model('Pembelian_model');
        $pembelian_model = new Pembelian_model();
        $this->load->model('Pembelian_bayar_model');
        $pembelian_bayar_model = new Pembelian_bayar_model();


        $content_data = array();
        $content_data['id_pembelian'] = $id_pembelian;
        $content_data['pembelian'] = $pembelian_model->detail($id_pembelian);
        $content_data['pembelian_bayar'] = $pembelian_bayar_model->get_list($id_pembelian);

        // print_r2($content_data['pembelian']);


        $content = $this->load->view('pembelian/pembelian_history_pembayaran_pdf', $content_data, true);
        // echo $content;
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A5', 'en');
        $html2pdf->writeHTML($content);
        $html2pdf->output();
    }
}
