<?php

class Kendaraan extends CI_Controller
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

        $template->set_content('kendaraan/kendaraan_list', []);
        $template->set_title('Kendaraan');
        $template->render();
    }
    function datatables()
    {
        $data = array();

        $sql = "SELECT  
                kendaraan.id_kendaraan,
                '' AS `action`,
                kendaraan.no_urut,
                kendaraan.show_at_home,
                kendaraan.nama_kendaraan,
                kendaraan.foto,
                kendaraan.lepas_kunci,
                kendaraan.with_driver
                FROM kendaraan
                where kendaraan.deleted = 0
                ORDER BY kendaraan.no_urut asc
                ";

        $db = $this->db->query($sql);
        foreach ($db->result_array() as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '<div style="width:150px" >';
                    $val .= '<a href="' . base_url('kendaraan/edit/' . $row['id_kendaraan']) . '" class="btn btn-primary btn-sm" >edit</a>';
                    $val .= '<a href="' . base_url('kendaraan/delete/' . $row['id_kendaraan']) . '" row_data="' . $row['nama_kendaraan'] . '" class="btn btn-danger btn-sm delete_btn" >delete</a>';
                    $val .= '</div>';
                }
                if ($key == 'foto') {
                    $val = '<img src="' . base_url('uploads/' . $row['foto']) . '" style="max-width:100px;max-height:150px;" >';
                }

                if ($key == 'lepas_kunci') {
                    $val = "Rp " . format_currency($val);
                }
                if ($key == 'with_driver') {
                    $val = "Rp " . format_currency($val);
                }

                if ($key == 'show_at_home') {
                    if (intval($val) == 1) {
                        $val = 'ya';
                    } else {
                        $val = 'jangan';
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
        $contet_data['nama_kendaraan'] = '';
        $contet_data['foto'] = '';
        $contet_data['lepas_kunci'] = '';
        $contet_data['with_driver'] = '';

        $db = $this->db->where('kendaraan.id_kendaraan', $id)->get('kendaraan');
        if ($db->num_rows() > 0) {
            $dbres = $db->row_array();
            $contet_data['id'] = $id;
            $contet_data['no_urut'] = $dbres['no_urut'];
            $contet_data['show_at_home'] = $dbres['show_at_home'];
            $contet_data['nama_kendaraan'] = $dbres['nama_kendaraan'];
            $contet_data['foto'] = $dbres['foto'];
            $contet_data['lepas_kunci'] = $dbres['lepas_kunci'];
            $contet_data['with_driver'] = $dbres['with_driver'];
        }

        $template = new Template();
        $template->set_content('kendaraan/kendaraan_edit', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Add Kendaraan');
        } else {
            $template->set_title('Edit Kendaraan');
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
        $this->form_validation->set_rules('nama_kendaraan', label2('nama_kendaraan'), 'trim|required');
        $this->form_validation->set_rules('lepas_kunci', label2('harga lepas_kunci'), 'trim|required');
        $this->form_validation->set_rules('with_driver', label2('harga with_driver'), 'trim|required');


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

                $insert['no_urut'] = in_post('no_urut');
                $insert['show_at_home'] = in_post('show_at_home');
                $insert['nama_kendaraan'] = in_post('nama_kendaraan');
                if (!empty($foto_uploaded)) {
                    $insert['foto'] = $foto_uploaded;
                }
                $insert['lepas_kunci'] = in_post('lepas_kunci');
                $insert['with_driver'] = floatval2(in_post('with_driver'));

                $this->db->insert('kendaraan', $insert);

                $this->session->set_flashdata('success_message', 'Tambah Berhasil');
            } else {
                $insert['no_urut'] = in_post('no_urut');
                $insert['show_at_home'] = in_post('show_at_home');
                $insert['nama_kendaraan'] = in_post('nama_kendaraan');
                if (!empty($foto_uploaded)) {
                    $insert['foto'] = $foto_uploaded;
                }
                $insert['lepas_kunci'] = in_post('lepas_kunci');
                $insert['with_driver'] = floatval2(in_post('with_driver'));

                $this->db->where('id_kendaraan', $id);
                $this->db->update('kendaraan', $insert);

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
        $this->db->where('id_kendaraan', $id);
        $this->db->update('kendaraan');
    }
}
