<?php

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        $this->db->where('deleted', 0);
        $this->db->limit(8);
        $db = $this->db->get('kendaraan');
        $content_data['kendaraan'] = $db->result_array();

        $this->db->where('deleted', 0);
        $this->db->limit(8);
        $db = $this->db->get('paket_wisata');
        $content_data['paket_wisata'] = $db->result_array();


        $data['content'] = load_view_html('home', $content_data);
        $this->load->view('template', $data);
    }
}
