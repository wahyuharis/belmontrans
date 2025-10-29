<?php
class Utang_penjualan_retur_model extends CI_Model
{

    function sql_list()
    {
        $start = $this->input->get('start');
        $limit = $this->input->get('length');

        $order_arr = $this->input->get('order');
        $order_col = $this->db->escape_str($order_arr[0]['column']);
        $order_dir = $this->db->escape_str($order_arr[0]['dir']);


        $filter_supplier = '';
        if (strlen(in_get('id_customer')) > 0) {
            $filter_supplier = " and  penjualan_retur.id_customer like " . $this->db->escape(in_get('id_customer')) . " ";
        }


        // print_r2($_GET);

        $sql = "SELECT 
                m_customer.id_customer,
                m_customer.nama_customer,
                m_customer.phone,
                m_customer.whatsapp,
                sum(penjualan_retur.total) AS total_penjualan_retur,
                SUM(penjualan_retur_total_bayar(penjualan_retur.id_penjualan_retur)) AS total_bayar,
                sum(penjualan_retur.total- penjualan_retur_total_bayar(penjualan_retur.id_penjualan_retur)) AS sisa_tagihan

                FROM penjualan_retur
                LEFT JOIN m_customer ON m_customer.id_customer=penjualan_retur.id_customer
                WHERE penjualan_retur.is_hutang=1
                and penjualan_retur.deleted=0
                ".$filter_supplier."

                GROUP BY penjualan_retur.id_customer
                ";



        if ($order_col == '0') {
            $sql .= " 
            order by m_customer.id_customer " . $order_dir . " 
            ";
        }
        if ($order_col == '1') {
            $sql .= " 
            order by m_customer.nama_customer " . $order_dir . " 
            ";
        }
        if ($order_col == '2') {
            $sql .= " 
            order by m_customer.phone " . $order_dir . " 
            ";
        }
        if ($order_col == '3') {
            $sql .= " 
            order by m_customer.whatsapp " . $order_dir . " 
            ";
        }
        if ($order_col == '4') {
            $sql .= " 
            order by sum(penjualan_retur.total) " . $order_dir . " 
            ";
        }
        if ($order_col == '5') {
            $sql .= " 
            order by SUM(penjualan_retur_total_bayar(penjualan_retur.id_penjualan_retur)) " . $order_dir . " 
            ";
        }

        if ($order_col == '6') {
            $sql .= " 
            order by sum(penjualan_retur.total- penjualan_retur_total_bayar(penjualan_retur.id_penjualan_retur)) " . $order_dir . " 
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