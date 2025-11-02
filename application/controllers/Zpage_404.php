<?php

class Zpage_404 extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        $template=new Template();

        $template->set_title('404 Error Page');
        $template->set_content('zpage_404', []);

        header("HTTP/1.0 404 Not Found");
        $template->render();
    }

}