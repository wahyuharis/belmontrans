<?php

class Paket_wisata extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        $this->db->where('deleted', 0);
        $db = $this->db->get('paket_wisata');
        $content_data['paket_wisata'] = $db->result_array();

        $data['content'] = load_view_html('paket_wisata', $content_data);
        $this->load->view('template', $data);
    }
}
