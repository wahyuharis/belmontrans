<?php

class Kontak extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        $data['content'] = load_view_html('kontak');

        $this->load->view('template', $data);
    }
}
