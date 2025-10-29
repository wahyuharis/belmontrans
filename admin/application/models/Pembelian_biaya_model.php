<?php
class Pembelian_biaya_model extends CI_Model
{

    function detail($id_pembelian){
        $this->db->where('id_pembelian',$id_pembelian);
        $this->db->join('m_biaya_lain','m_biaya_lain.id_biaya_lain=pembelian_biaya.id_biaya_lain','left');
        $db=$this->db->get('pembelian_biaya');
        if($db->num_rows()>0){
            return $db->result_array();
        }else{
            return array();;
        }
    }

}