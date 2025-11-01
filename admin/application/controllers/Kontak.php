<?php

class Kontak extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $auth = new Auth();
        $auth->logged_in();
    }

    function index()
    {
        $template = new Template();

        $template->set_content('kontak/kontak_list', []);
        $template->set_title('Kontak');
        $template->render();
    }
    function datatables()
    {
        $data = array();

        $sql = "SELECT 
                kontak.id_kontak,
                '' AS `action`,
                kontak.nama_kontak,
                kontak.alamat_kontak,
                kontak.`url` 
                FROM kontak
                ORDER BY kontak.id_kontak asc
                ";

        $db = $this->db->query($sql);
        foreach ($db->result_array() as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '<div style="width:150px" >';
                    $val .= '<a href="' . base_url('kontak/edit/' . $row['id_kontak']) . '" class="btn btn-primary btn-sm" >edit</a>';
                    $val .= '</div>';
                }


                array_push($buff, $val);
            }
            array_push($data, $buff);
        }

        header_json();
        $res = array(
            'data' => $data,
        );
        echo json_encode($res);
    }

    function edit($id = '')
    {

        $contet_data['id'] = $id;
        $contet_data['nama_kontak'] = '';
        $contet_data['alamat_kontak'] = '';
        $contet_data['url'] = '';


        $db = $this->db->where('kontak.id_kontak', $id)->get('kontak');
        if ($db->num_rows() > 0) {
            $dbres = $db->row_array();
            $contet_data['id'] = $id;
            $contet_data['nama_kontak'] = $dbres['nama_kontak'];
            $contet_data['alamat_kontak'] = $dbres['alamat_kontak'];
            $contet_data['url'] = $dbres['url'];
        }

        $template = new Template();
        $template->set_content('kontak/kontak_edit', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Add Kontak');
        } else {
            $template->set_title('Edit Kontak');
        }

        $template->render();
    }

    function submit()
    {
        $message = '';
        $data = [];
        $success = false;

        $post_data = $this->input->post();
        // print_r2($post_data);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_kontak', label2('nama_kontak'), 'trim|required');
        $this->form_validation->set_rules('alamat_kontak', label2('alamat_kontak'), 'trim|required');
        // $this->form_validation->set_rules('caption', label2('caption'), 'trim|required');
        // $this->form_validation->set_rules('url', label2('url'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $success = false;
            $message .= validation_errors();
        } else {
            $success = true;
        }


        $id = in_post('id');
        if ($success) {

            $insert['nama_kontak'] = in_post('nama_kontak');
            $insert['alamat_kontak'] = in_post('alamat_kontak');
            $insert['url'] = in_post('url');

            $this->db->where('id_kontak', $id);
            $this->db->update('kontak', $insert);

            $this->session->set_flashdata('success_message', 'Edit Berhasil');
        }


        $res = array(
            'message' => $message,
            'data' => $data,
            'success' => $success,
        );
        header_json();
        echo json_encode($res);
    }

}
