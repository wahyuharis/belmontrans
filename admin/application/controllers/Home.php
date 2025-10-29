<?php

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $auth=new Auth();
        $auth->logged_in();
    }

    function index()
    {
        $template=new Template();

        $template->set_content('home', []);
        $template->set_title('Home');
        $template->render();

    }

}