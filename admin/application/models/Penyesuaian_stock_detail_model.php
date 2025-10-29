<?php
class Penyesuaian_stock_detail_model extends CI_Model
{

    function detail($id_penyesuaian_stock)
    {
        $this->db->where('penyesuaian_stock_detail.id_penyesuaian_stock',$id_penyesuaian_stock);
        $this->db->join('m_item','penyesuaian_stock_detail.id_item=m_item.id_item','left');
        $db = $this->db->get('penyesuaian_stock_detail');

		if($db->num_rows()>0){
            return $db->result_array();
        }else{
            return false;
        }
    }
}
