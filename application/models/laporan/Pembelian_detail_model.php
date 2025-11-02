<?php
class Pembelian_detail_model extends CI_Model
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

            $filter_tanggal = "and (pembelian.tanggal between  '" . $this->db->escape_str($tanggal) . " 00:00:00' and '" . $this->db->escape_str($tanggal2) . " 23:59:59')";
        }

        $filter_supplier = '';
        if (strlen(in_get('id_supplier')) > 0) {
            $filter_supplier = " and  pembelian.id_supplier like " . $this->db->escape(in_get('id_supplier')) . " ";
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
                    tb.total_qty,
                    tb.total
                FROM m_item
                LEFT join
                    (
                        SELECT 
                        pembelian_detail.id_item,
                        sum(pembelian_detail.`qty`) AS total_qty,
                        SUM(pembelian_detail.sub) AS total  
                        FROM pembelian
                        right JOIN pembelian_detail ON pembelian_detail.id_pembelian=pembelian.id_pembelian
                        WHERE 
                        pembelian.deleted=0
                        " . $filter_tanggal . "
                        " . $filter_supplier . "
                        
                        GROUP BY pembelian_detail.id_item
                    ) AS tb ON tb.id_item=m_item.id_item
                LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori

                WHERE m_item.deleted=0
                " . $filter_item . "
                " . $filter_id_kategori . "
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
            order by tb.total_qty " . $order_dir . " 
            ";
        }
        if ($order_col == '5') {
            $sql .= " 
            order by tb.total " . $order_dir . " 
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
