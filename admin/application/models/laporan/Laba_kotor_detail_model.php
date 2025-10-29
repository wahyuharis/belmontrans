<?php
class Laba_kotor_detail_model extends CI_Model
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

            $filter_tanggal = "and (penjualan.tanggal between  '" . $this->db->escape_str($tanggal) . " 00:00:00' and '" . $this->db->escape_str($tanggal2) . " 23:59:59')";
            $filter_tanggal2 = "and (penjualan_retur.tanggal between  '" . $this->db->escape_str($tanggal) . " 00:00:00' and '" . $this->db->escape_str($tanggal2) . " 23:59:59')";
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
                m_item.barcode,
                m_item.nama_item,
                m_kategori.nama_kategori,
                
                (coalesce(tb.qty_penjualan,0)- coalesce(tb2.qty_penjualan_retur,0)) AS qty_penjualan_fix,
                (coalesce(tb.total_penjualan,0)- coalesce(tb2.total_penjualan_retur,0)) AS sales,
                ( coalesce(tb.total_hpp_penjualan,0)- coalesce(tb2.total_hpp_penjualan_retur,0)) AS cogs,
                (( coalesce(tb.total_penjualan,0)-coalesce(tb2.total_penjualan_retur,0)) - (coalesce(tb.total_hpp_penjualan,0)- coalesce(tb2.total_hpp_penjualan_retur,0)) ) AS provit
                FROM m_item
                
                LEFT JOIN 
                (
                    SELECT 
                    penjualan_detail.id_item,
                    sum(penjualan_detail.qty) AS qty_penjualan,
                    sum(penjualan_detail.sub) AS total_penjualan,
                    sum( COALESCE(penjualan_detail.qty,0) * COALESCE(penjualan_detail.hpp,0) ) AS total_hpp_penjualan
                    FROM penjualan
                    LEFT JOIN penjualan_detail ON penjualan_detail.id_penjualan=penjualan.id_penjualan
                    
                    WHERE penjualan.deleted=0
                    ".$filter_tanggal."
                    
                    GROUP BY penjualan_detail.id_item
                ) AS tb on tb.id_item=m_item.id_item
                LEFT JOIN
                (
                    SELECT 
                    penjualan_retur_detail.id_item AS id_item_penjualan_retur,
                    sum(penjualan_retur_detail.qty) AS qty_penjualan_retur,
                    sum(penjualan_retur_detail.sub) AS `total_penjualan_retur`,
                    SUM(( COALESCE(penjualan_retur_detail.qty,0) * coalesce(penjualan_retur_detail.hpp,0) )) AS total_hpp_penjualan_retur
                    FROM penjualan_retur
                    LEFT JOIN penjualan_retur_detail ON penjualan_retur_detail.id_penjualan_retur=penjualan_retur.id_penjualan_retur
                    JOIN penjualan ON penjualan.id_penjualan=penjualan_retur.id_penjualan
                    
                    WHERE penjualan.deleted=0
                    AND penjualan_retur.deleted=0
                    ".$filter_tanggal2."
                    
                    GROUP BY penjualan_retur_detail.id_item
                ) AS tb2 ON tb2.id_item_penjualan_retur=m_item.id_item
                LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
                WHERE 
	            m_item.deleted=0
                ".$filter_item."
                ".$filter_id_kategori."

                ";



        if ($order_col == '0') {
            $sql .= " 
            order by m_item.id_item " . $order_dir . " 
            ";
        }
        if ($order_col == '2') {
            $sql .= " 
            order by m_item.nama_item " . $order_dir . " 
            ";
        }
        if ($order_col == '3') {
            $sql .= " 
            order by m_kategori.nama_kategori " . $order_dir . " 
            ";
        }
        if ($order_col == '4') {
            $sql .= " 
            order by (coalesce(tb.qty_penjualan,0)- coalesce(tb2.qty_penjualan_retur,0)) " . $order_dir . " 
            ";
        }
        if ($order_col == '5') {
            $sql .= " 
            order by (coalesce(tb.total_penjualan,0)- coalesce(tb2.total_penjualan_retur,0)) " . $order_dir . " 
            ";
        }
        if ($order_col == '6') {
            $sql .= " 
            (coalesce(tb.total_hpp_penjualan,0)- coalesce(tb2.total_hpp_penjualan_retur,0)) " . $order_dir . " 
            ";
        }
        if ($order_col == '7') {
            $sql .= " 
            ((coalesce(tb.total_penjualan,0)-coalesce(tb2.total_penjualan_retur,0)) - (coalesce(tb.total_hpp_penjualan,0)- coalesce(tb2.total_hpp_penjualan_retur,0)) ) " . $order_dir . " 
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
