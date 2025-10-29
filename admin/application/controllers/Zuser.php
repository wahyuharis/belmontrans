<?php

class Zuser extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $auth = new Auth();
        $auth->logged_in();
        $auth->harus_superadmin();
    }

    function index()
    {

        $template = new Template();

        $template->set_content('zuser/user_list', []);
        $template->set_title('User');
        $template->render();
    }
    function datatables()
    {
        $data = array();

        $sql = "SELECT id_users,
                    '' AS action,
                    users.username,
                    users.email,
                    users_jabatan.nama_jabatan
                FROM users
                LEFT JOIN users_jabatan ON users_jabatan.id_jabatan=users.id_jabatan
                ORDER BY users.id_users DESC
                ";

        $db = $this->db->query($sql);
        foreach ($db->result_array() as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '<div style="width:100px" >';
                    $val .= '<a href="' . base_url('zuser/edit/' . $row['id_users']) . '" class="btn btn-primary btn-sm" >edit</a>';
                    // $val .= '<a href="' . base_url('zuser/detail/' . $row['id_users']) . '" class="btn btn-success btn-sm" >detail</a>';
                    $val .= '<a href="' . base_url('zuser/delete/' . $row['id_users']) . '" class="btn btn-danger btn-sm delete_btn" >delete</a>';
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

    function add()
    {
        $this->edit('');
    }

    function edit($id = '')
    {

        $contet_data['id'] = $id;
        $contet_data['username'] = '';
        $contet_data['email'] = '';
        $contet_data['id_jabatan'] = '';

        $db = $this->db->get('users_jabatan');
        $opt_jabatan = $db->result_array();
        $contet_data['opt_jabatan'] = dropdown_array($opt_jabatan, 'id_jabatan', 'nama_jabatan', '-- Pilih Jabatan --');

        $db = $this->db->where('id_users', $id)->get('users');
        if ($db->num_rows() > 0) {
            $dbres = $db->row_array();
            $contet_data['id'] = $id;
            $contet_data['username'] = $dbres['username'];
            $contet_data['email'] = $dbres['email'];
            $contet_data['id_jabatan'] = $dbres['id_jabatan'];
        }

        $template = new Template();
        $template->set_content('zuser/user_edit', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Add User');
        } else {
            $template->set_title('Edit User');
        }

        $template->render();
    }

    function submit()
    {
        $message = '';
        $data = [];
        $success = true;

        $post_data = $this->input->post();
        $id = in_post('id');


        // print_r2($post_data);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('id_jabatan', 'Jabatan', 'trim|required');

        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('password2', 'Ulangi Password', 'trim|required');
        }
        if ($this->form_validation->run() == FALSE) {
            $success = false;
            $message .= validation_errors();
        }
        if (!empty(in_post('password'))) {
            if (in_post('password') != in_post('password2')) {
                $success = false;
                $message .= "<p>Password Tidak Sama</p>";
            }
        }
        if (empty($id)) {
            $this->db->where('username', in_post('username'));
            $this->db->from('users');
            $count = $this->db->count_all_results();
            if ($count > 0) {
                $success=false;
                $message.="<p>Username Sudah Ada</p>";
            }
            $this->db->where('email', in_post('email'));
            $this->db->from('users');
            $count = $this->db->count_all_results();
            if ($count > 0) {
                $success=false;
                $message.="<p>Email Sudah Ada</p>";
            }
        }else{
            $this->db->where('username', in_post('username'));
            $this->db->where('id_users !=',$id);
            $this->db->from('users');
            $count = $this->db->count_all_results();
            if ($count > 0) {
                $success=false;
                $message.="<p>Username Sudah Ada</p>";
            }
            $this->db->where('email', in_post('email'));
            $this->db->where('id_users !=',$id);
            $this->db->from('users');
            $count = $this->db->count_all_results();
            if ($count > 0) {
                $success=false;
                $message.="<p>Email Sudah Ada</p>";
            }
        }



        if ($success) {
            if (empty($id)) {

                $insert['username'] = in_post('username');
                $insert['email'] = in_post('email');
                $insert['id_jabatan'] = in_post('id_jabatan');
                $insert['password'] = md5(in_post('password'));


                $this->db->insert('users', $insert);

                $this->session->set_flashdata('success_message', 'Tambah Berhasil');
            } else {
                $insert['username'] = in_post('username');
                $insert['email'] = in_post('email');
                $insert['id_jabatan'] = in_post('id_jabatan');
                if (!empty(in_post('password'))) {
                    $insert['password'] = md5(in_post('password'));
                }

                $this->db->where('id_users', $id);
                $this->db->update('users', $insert);

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
        $this->db->where('id_users', $id);
        $this->db->delete('users');
    }
}
