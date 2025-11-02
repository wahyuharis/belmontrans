<?php
class Pembelian_retur_detail_model extends CI_Model
{

	function detail($id_pembelian_retur)
	{
        $this->db->where('id_pembelian_retur',$id_pembelian_retur);
        $this->db->join('m_item','m_item.id_item=pembelian_retur_detail.id_item','left');
        $db=$this->db->get('pembelian_retur_detail');
        if($db->num_rows()>0){
            return $db->result_array();
        }else{
            return false;
        }
    }
}