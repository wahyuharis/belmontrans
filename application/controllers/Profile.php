<?php

class Profile extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        $data['content'] = load_view_html('profile');

        $this->load->view('template', $data);
    }
}
