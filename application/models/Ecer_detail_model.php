<?php
class Ecer_detail_model extends CI_Model
{

    function detail($id_ecer)
    {
        $sql = "SELECT 
                ecer_detail.id_ecer,
                ecer_detail.id_item_grosir,
                item_grosir.nama_item AS nama_item_grosir,
                ecer_detail.qty_grosir,
                ecer_detail.hpp_grosir,
                ecer_detail.hpp_total_grosir,
                ecer_detail.id_item_ecer,
                item_ecer.nama_item AS nama_item_ecer,
                ecer_detail.qty_ecer,
                ecer_detail.hpp_ecer,
                ecer_detail.hpp_total_ecer
                FROM ecer_detail
                LEFT JOIN m_item item_grosir ON item_grosir.id_item=ecer_detail.id_item_grosir
                LEFT JOIN m_item item_ecer ON item_ecer.id_item=ecer_detail.id_item_ecer
                
                where ecer_detail.id_ecer=" . $this->db->escape($id_ecer) . " ";

        $db = $this->db->query($sql);

        if ($db->num_rows() > 0) {
            return $db->result_array();
        } else {
            return false;
        }
    }
}
