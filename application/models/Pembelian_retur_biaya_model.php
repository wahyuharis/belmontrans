<?php
class Pembelian_retur_biaya_model extends CI_Model
{

    function detail($id_pembelian_retur){
        $this->db->where('id_pembelian_retur',$id_pembelian_retur);
        $this->db->join('m_biaya_lain','m_biaya_lain.id_biaya_lain=pembelian_retur_biaya.id_biaya_lain','left');
        $db=$this->db->get('pembelian_retur_biaya');
        if($db->num_rows()>0){
            return $db->result_array();
        }else{
            return array();;
        }
    }

}