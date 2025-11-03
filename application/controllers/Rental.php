<?php

class Rental extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        $data['content'] = load_view_html('rental');

        $this->load->view('template', $data);
    }
}
