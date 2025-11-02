<?php
class Utang_pembelian_model extends CI_Model
{

    function sql_list()
    {
        $start = $this->input->get('start');
        $limit = $this->input->get('length');

        $order_arr = $this->input->get('order');
        $order_col = $this->db->escape_str($order_arr[0]['column']);
        $order_dir = $this->db->escape_str($order_arr[0]['dir']);


        $filter_supplier = '';
        if (strlen(in_get('id_supplier')) > 0) {
            $filter_supplier = " and  pembelian.id_supplier like " . $this->db->escape(in_get('id_supplier')) . " ";
        }


        // print_r2($_GET);

        $sql = "SELECT 
                m_supplier.id_supplier,
                m_supplier.nama_supplier,
                m_supplier.phone,
                m_supplier.whatsapp,
                sum(pembelian.total) AS total_pembelian,
                sum(pembelian_total_bayar(pembelian.id_pembelian)) AS total_bayar,
                sum(pembelian.total- pembelian_total_bayar(pembelian.id_pembelian)) AS sisa_tagihan

                FROM pembelian
                LEFT JOIN m_supplier ON m_supplier.id_supplier=pembelian.id_supplier
                WHERE pembelian.is_hutang=1
                and pembelian.deleted=0
                ".$filter_supplier."

                GROUP BY pembelian.id_supplier
                ";



        if ($order_col == '0') {
            $sql .= " 
            order by m_supplier.id_supplier " . $order_dir . " 
            ";
        }
        if ($order_col == '1') {
            $sql .= " 
            order by m_supplier.nama_supplier " . $order_dir . " 
            ";
        }
        if ($order_col == '2') {
            $sql .= " 
            order by m_supplier.phone " . $order_dir . " 
            ";
        }
        if ($order_col == '3') {
            $sql .= " 
            order by m_supplier.whatsapp " . $order_dir . " 
            ";
        }
        if ($order_col == '4') {
            $sql .= " 
            order by sum(pembelian.total) " . $order_dir . " 
            ";
        }
        if ($order_col == '5') {
            $sql .= " 
            order by sum(pembelian_total_bayar(pembelian.id_pembelian)) " . $order_dir . " 
            ";
        }

        if ($order_col == '6') {
            $sql .= " 
            order by sum(pembelian.total- pembelian_total_bayar(pembelian.id_pembelian)) " . $order_dir . " 
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