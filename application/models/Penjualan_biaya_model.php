<?php
class Penjualan_biaya_model extends CI_Model
{

    function detail($id_penjualan){
        $this->db->where('id_penjualan',$id_penjualan);
        $this->db->join('m_biaya_lain','m_biaya_lain.id_biaya_lain=penjualan_biaya.id_biaya_lain','left');
        $db=$this->db->get('penjualan_biaya');
        if($db->num_rows()>0){
            return $db->result_array();
        }else{
            return array();;
        }
    }

}