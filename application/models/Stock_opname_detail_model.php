<?php
class Stock_opname_detail_model extends CI_Model
{

    function detail($id_stock_opname)
    {
        $this->db->where('stock_opname_detail.id_stock_opname',$id_stock_opname);
        $this->db->join('m_item','stock_opname_detail.id_item=m_item.id_item','left');
        $db = $this->db->get('stock_opname_detail');

		if($db->num_rows()>0){
            return $db->result_array();
        }else{
            return false;
        }
    }
}
