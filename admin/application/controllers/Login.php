<?php

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $username = $this->session->userdata('username');
        $email = $this->session->userdata('email');
        $password = $this->session->userdata('password');

        if ((!empty(trim($username))) && (!empty(trim($password)))) {
            redirect('home');
        } else {
            $this->load->view('login');
        }
    }

    function submit()
    {
        $message = "";
        $data = [];
        $success = false;

        $username = in_post('username');
        $password = in_post('password');
        $password = md5($password);

        $where = " (username = " . $this->db->escape($username) . " or email = " . $this->db->escape($username) . " ) 
        and password = " . $this->db->escape($password) . " 
        ";
        $db = $this->db->where($where)->get('users');

        // echo $this->db->last_query();
        // die();

        if ($db->num_rows() > 0) {
            $userdata = $db->row_array();
            $this->session->set_userdata($userdata);
            $success = true;
        } else {
            $success = false;
            $message = "Maaf Username Dan Password Tidak Cocok";
        }

        $res = array(
            'message' => $message,
            'data' => $data,
            'success' => $success
        );

        header_json();
        echo json_encode($res);
    }

    function logout()
    {
        // $this->session->sess_destroy();
        // print_r2($this->session->userdata());
        $this->session->unset_userdata('id_users');
        $this->session->unset_userdata('id_jabatan');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('password');

        $this->session->set_flashdata('success_message', 'Anda Telah Logout');
        redirect('login');
    }
}
