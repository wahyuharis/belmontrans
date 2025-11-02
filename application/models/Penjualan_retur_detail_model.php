<?php
class Penjualan_retur_detail_model extends CI_Model
{

	function detail($id_penjualan_retur)
	{
        $this->db->where('id_penjualan_retur',$id_penjualan_retur);
        $this->db->join('m_item','m_item.id_item=penjualan_retur_detail.id_item','left');
        $db=$this->db->get('penjualan_retur_detail');
        if($db->num_rows()>0){
            return $db->result_array();
        }else{
            return false;
        }
    }
}