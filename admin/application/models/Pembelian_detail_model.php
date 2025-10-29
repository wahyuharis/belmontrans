<?php
class Pembelian_detail_model extends CI_Model
{

	function detail($id_pembelian)
	{
        $this->db->where('id_pembelian',$id_pembelian);
        $this->db->join('m_item','m_item.id_item=pembelian_detail.id_item','left');
        $db=$this->db->get('pembelian_detail');
        if($db->num_rows()>0){
            return $db->result_array();
        }else{
            return false;
        }
    }
}
