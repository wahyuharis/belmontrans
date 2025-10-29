<?php
class Stock_opname_detail_model extends CI_Model
{

    function sql_list()
    {
        $start = $this->input->get('start');
        $limit = $this->input->get('length');

        $order_arr = $this->input->get('order');
        $order_col = $this->db->escape_str($order_arr[0]['column']);
        $order_dir = $this->db->escape_str($order_arr[0]['dir']);


        $filter_tanggal = '';
        if (strlen($this->input->get('tanggal')) > 0 and strlen($this->input->get('tanggal2')) > 0) {
            $tanggal = $this->input->get('tanggal');
            $tanggal2 = $this->input->get('tanggal2');

            $tanggal = waktu_dmy_to_ymd($tanggal);
            $tanggal2 = waktu_dmy_to_ymd($tanggal2);

            $filter_tanggal = " stock_opname.tanggal between  '" . $this->db->escape_str($tanggal) . " 00:00:00' and '" . $this->db->escape_str($tanggal2) . " 23:59:59' ";
        }

        $filter_id_kategori = ' ';
        if (strlen(in_get('id_kategori')) > 0) {
            $filter_id_kategori = " and m_item.id_kategori like " . $this->db->escape(in_get('id_kategori')) . " ";
        }

        $filter_item = ' ';
        if (strlen(in_get('id_item')) > 0) {
            $filter_item = " and m_item.id_item like " . $this->db->escape(in_get('id_item')) . " ";
        }


        // print_r2($_GET);

        $sql = "SELECT  
                m_item.id_item,
                m_item.nama_item,
                m_kategori.nama_kategori,
                tb.qty_disesuaikan,
                tb.hpp_disesuaikan
                FROM m_item
                LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
                LEFT JOIN (SELECT  
                stock_opname_detail.id_item,
                sum(stock_opname_detail.qty_selisih) AS qty_disesuaikan,
                SUM( stock_opname_detail.qty_selisih * stock_opname_detail.hpp ) AS hpp_disesuaikan

                FROM stock_opname
                JOIN stock_opname_detail ON stock_opname_detail.id_stock_opname =stock_opname.id_stock_opname

                WHERE 
                ".$filter_tanggal."

                GROUP BY stock_opname_detail.id_item) AS tb ON tb.id_item=m_item.id_item

                WHERE m_item.deleted=0
                AND m_item.hitung_stock=1
                ".$filter_item."
                ".$filter_id_kategori."

                ";


                // print_r2($sql);
            


        if ($order_col == '0') {
            $sql .= " 
            order by m_item.id_item " . $order_dir . " 
            ";
        }
        if ($order_col == '1') {
            $sql .= " 
            order by m_item.nama_item " . $order_dir . " 
            ";
        }
        if ($order_col == '2') {
            $sql .= " 
            order by m_kategori.nama_kategori " . $order_dir . " 
            ";
        }
        if ($order_col == '3') {
            $sql .= " 
            order by tb.qty_disesuaikan " . $order_dir . " 
            ";
        }
        if ($order_col == '4') {
            $sql .= " 
            order by tb.hpp_disesuaikan " . $order_dir . " 
            ";
        }

        $totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");
        if (intval($limit) > 0) {
            $sql .= "limit " . intval($start) . "," . intval($limit) . " ";
        }
        $data = $this->db->query($sql);


        return array(
            'data' => $data->result_array(),
            'totalrows' => $totalrows->row_array()['totalrows'],
        );
    }
}
