<?php
class Penjualan_detail_model extends CI_Model
{

	function detail($id_penjualan)
	{
        $this->db->where('id_penjualan',$id_penjualan);
        $this->db->join('m_item','m_item.id_item=penjualan_detail.id_item','left');
        $db=$this->db->get('penjualan_detail');
        if($db->num_rows()>0){
            return $db->result_array();
        }else{
            return false;
        }
    }
}