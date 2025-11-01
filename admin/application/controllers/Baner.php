<?php

class Baner extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $auth = new Auth();
        $auth->logged_in();
    }

    function index()
    {
        // $segment1 = segment_uri(1);
        // print_r2($segment1);

        $template = new Template();

        $template->set_content('baner/baner_list', []);
        $template->set_title('Baner');
        $template->render();
    }
    function datatables()
    {
        $data = array();

        $sql = "SELECT
                baner.id_baner,
                '' AS `action`,
                baner.nama_baner,
                baner.foto,
                baner.title,
                baner.caption,
                baner.`url`
                FROM baner
                ORDER BY baner.id_baner asc
                ";

        $db = $this->db->query($sql);
        foreach ($db->result_array() as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '<div style="width:150px" >';
                    $val .= '<a href="' . base_url('baner/edit/' . $row['id_baner']) . '" class="btn btn-primary btn-sm" >edit</a>';
                    $val .= '</div>';
                }

                if ($key == 'foto') {
                    $val = '<img src="' . base_url('uploads/' . $row['foto']) . '" style="max-width:100px;max-height:150px;" >';
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
        $contet_data['nama_baner'] = '';
        $contet_data['foto'] = '';
        $contet_data['title'] = '';
        $contet_data['caption'] = '';
        $contet_data['url'] = '';


        $db = $this->db->where('baner.id_baner', $id)->get('baner');
        if ($db->num_rows() > 0) {
            $dbres = $db->row_array();
            $contet_data['id'] = $id;
            $contet_data['nama_baner'] = $dbres['nama_baner'];
            $contet_data['foto'] = $dbres['foto'];
            $contet_data['title'] = $dbres['title'];
            $contet_data['caption'] = $dbres['caption'];
            $contet_data['url'] = $dbres['url'];
        }

        $template = new Template();
        $template->set_content('baner/baner_edit', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Add Baner');
        } else {
            $template->set_title('Edit Baner');
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
        $this->form_validation->set_rules('nama_baner', label2('nama_baner'), 'trim|required');
        $this->form_validation->set_rules('title', label2('title'), 'trim|required');
        // $this->form_validation->set_rules('caption', label2('caption'), 'trim|required');
        // $this->form_validation->set_rules('url', label2('url'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $success = false;
            $message .= validation_errors();
        } else {
            $success = true;
        }

        $foto_uploaded = "";
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto')) {
            $upload_data = $this->upload->data();
            $foto_uploaded = $upload_data['file_name'];
        }

        $id = in_post('id');
        if ($success) {

            $insert['nama_baner'] = in_post('nama_baner');
            if (!empty($foto_uploaded)) {
                $insert['foto'] = $foto_uploaded;
            }
            $insert['title'] = in_post('title');
            $insert['caption'] = in_post('caption');
            $insert['url'] = in_post('url');

            $this->db->where('id_baner', $id);
            $this->db->update('baner', $insert);

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
