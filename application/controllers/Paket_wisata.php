<?php

class Paket_wisata extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        $data['content'] = load_view_html('paket_wisata');

        $this->load->view('template', $data);
    }
}
