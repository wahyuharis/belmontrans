<?php
class Ecer_model extends CI_Model
{


    function detail($id_ecer)
    {

        $sql = "SELECT 
                ecer.id_ecer,
                '' AS `action`,
                ecer.id_ecer,
                date_format(ecer.tanggal,'%d/%m/%Y') AS `tanggal`,
                users.username,
                ecer.keterangan
                FROM ecer
                LEFT JOIN users ON users.id_users=ecer.id_users
                WHERE ecer.id_ecer =" . $this->db->escape($id_ecer) . " ";

        $db = $this->db->query($sql);

        $db = $this->db->query($sql);
        if ($db->num_rows() > 0) {
            return $db->row_array();
        } else {
            return false;
        }
    }
}
