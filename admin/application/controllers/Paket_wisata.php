<?php

class Paket_wisata extends CI_Controller
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

        $template->set_content('paket_wisata/paket_wisata_list', []);
        $template->set_title('Paket Wisata');
        $template->render();
    }
    function datatables()
    {
        $data = array();

        $sql = "SELECT
                paket_wisata.id_wisata,
                '' AS `action`,
                paket_wisata.no_urut,
                paket_wisata.show_at_home,
                paket_wisata.nama_wisata,
                paket_wisata.foto,
                TO_BASE64(paket_wisata.destinasi) as destinasi,
                paket_wisata.harga
                FROM
                paket_wisata
                WHERE paket_wisata.deleted = 0
                ORDER BY paket_wisata.no_urut asc
                ";

        $db = $this->db->query($sql);
        foreach ($db->result_array() as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '<div style="width:150px" >';
                    $val .= '<a href="' . base_url('paket_wisata/edit/' . $row['id_wisata']) . '" class="btn btn-primary btn-sm" >edit</a>';
                    $val .= '<a href="' . base_url('paket_wisata/delete/' . $row['id_wisata']) . '" row_data="' . $row['nama_wisata'] . '" class="btn btn-danger btn-sm delete_btn" >delete</a>';
                    $val .= '</div>';
                }
                if ($key == 'foto') {
                    $val = '<img src="' . base_url('uploads/' . $row['foto']) . '" style="max-width:100px;max-height:150px;" >';
                }

                if ($key == 'destinasi') {
                    $json_col = base64_decode($val);
                    $arr_col = json_decode($json_col, true);
                    $val = "<ul>";
                    foreach ($arr_col as $row2) {
                        $val .= "<li>" . $row2['nama_destinasi'] . "</li>";
                    }
                    $val .= "</ul>";
                }

                if ($key == 'harga') {
                    $val = "Rp " . format_currency($val);
                }

                if($key=='show_at_home'){
                    if(intval($val)==1){
                        $val='ya';
                    }else{
                        $val='jangan';
                    }
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

    function add()
    {
        $this->edit('');
    }

    function edit($id = '')
    {

        $contet_data['id'] = $id;
        $contet_data['no_urut'] = '';
        $contet_data['show_at_home'] = '';
        $contet_data['nama_wisata'] = '';
        $contet_data['foto'] = '';
        $contet_data['destinasi'] = array();
        $contet_data['harga'] = '';

        $db = $this->db->where('paket_wisata.id_wisata', $id)->get('paket_wisata');
        if ($db->num_rows() > 0) {
            $dbres = $db->row_array();
            $contet_data['id'] = $id;
            $contet_data['no_urut'] = $dbres['no_urut'];
            $contet_data['show_at_home'] = $dbres['show_at_home'];
            $contet_data['nama_wisata'] = $dbres['nama_wisata'];
            $contet_data['foto'] = $dbres['foto'];
            $contet_data['destinasi'] =  json_decode(trim($dbres['destinasi']), true);
            $contet_data['harga'] = $dbres['harga'];
        }


        // print_r2($contet_data['destinasi']);

        $template = new Template();
        $template->set_content('paket_wisata/paket_wisata_edit', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Add Paket Wisata');
        } else {
            $template->set_title('Edit Paket Wisata');
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
        $this->form_validation->set_rules('no_urut', label2('no_urut'), 'trim|required');
        $this->form_validation->set_rules('show_at_home', label2('tampilkan di home'), 'trim|required');
        $this->form_validation->set_rules('nama_wisata', label2('nama_wisata'), 'trim|required');
        $this->form_validation->set_rules('destinasi', label2('destinasi'), 'trim|required');
        $this->form_validation->set_rules('harga', label2('harga'), 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $success = false;
            $message .= validation_errors();
        } else {
            $success = true;
        }

        $foto_uploaded = "";
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto')) {
            $upload_data = $this->upload->data();
            $foto_uploaded = $upload_data['file_name'];
        } else {
            $error =  $this->upload->display_errors();
            // print_r2($error);
        }

        // print_r2($_FILES);
        // print_r2($foto_uploaded);

        $id = in_post('id');

        if ($success) {
            if (empty($id)) {

                $insert['no_urut'] = floatval2(in_post('no_urut'));
                $insert['show_at_home'] = in_post('show_at_home');
                $insert['nama_wisata'] = in_post('nama_wisata');
                if (!empty($foto_uploaded)) {
                    $insert['foto'] = $foto_uploaded;
                }
                $insert['destinasi'] = in_post('destinasi');
                $insert['harga'] = floatval2(in_post('harga'));

                $this->db->insert('paket_wisata', $insert);

                $this->session->set_flashdata('success_message', 'Tambah Berhasil');
            } else {
                $insert['no_urut'] = floatval2(in_post('no_urut'));
                $insert['show_at_home'] = in_post('show_at_home');
                $insert['nama_wisata'] = in_post('nama_wisata');
                if (!empty($foto_uploaded)) {
                    $insert['foto'] = $foto_uploaded;
                }
                $insert['destinasi'] = in_post('destinasi');
                $insert['harga'] = floatval2(in_post('harga'));

                $this->db->where('id_wisata', $id);
                $this->db->update('paket_wisata', $insert);

                $this->session->set_flashdata('success_message', 'Edit Berhasil');
            }
        }


        $res = array(
            'message' => $message,
            'data' => $data,
            'success' => $success,
        );
        header_json();
        echo json_encode($res);
    }


    function delete($id)
    {
        $set = array(
            'deleted' => 1
        );
        $this->db->set($set);
        $this->db->where('id_wisata', $id);
        $this->db->update('paket_wisata');
    }
}
