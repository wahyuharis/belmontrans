<?php
class Penyesuaian_stock_model extends CI_Model
{

    function sql_list()
    {
        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search = $this->input->get('search');
        $search_text = $this->db->escape_str(trim($search['value']));

        $order_arr = $this->input->get('order');
        $order_col = $this->db->escape_str($order_arr[0]['column']);
        $order_dir = $this->db->escape_str($order_arr[0]['dir']);

        // print_r2($search);


        $sql = "
            SELECT 
            penyesuain_stock.id_penyesuaian_stock,
            '' AS `action`,
            penyesuain_stock.id_penyesuaian_stock as `ID`,
            date_format(penyesuain_stock.tanggal,'%d/%m/%Y') AS `tanggal`,
            users.username,
            penyesuain_stock.hpp_selisih_total
            FROM penyesuain_stock
            LEFT JOIN users ON users.id_users=penyesuain_stock.id_users
            where
            penyesuain_stock.id_penyesuaian_stock like '%".$search_text."%'
            or
            date_format(penyesuain_stock.tanggal,'%d/%m/%Y') like '%".$search_text."%'
            or
            users.username like '%".$search_text."%'
            or
            penyesuain_stock.hpp_selisih_total like '%".$search_text."%'
        ";


        if ($order_col == '0') {
            $sql .= " 
            order by penyesuain_stock.id_penyesuaian_stock " . $order_dir . " 
            ";
        }

        if ($order_col == '2') {
            $sql .= " 
            order by penyesuain_stock.id_penyesuaian_stock " . $order_dir . " 
            ";
        }

        if ($order_col == '3') {
            $sql .= " 
            order by penyesuain_stock.tanggal " . $order_dir . " 
            ";
        }

        if ($order_col == '4') {
            $sql .= " 
            order by users.username " . $order_dir . " 
            ";
        }

        if ($order_col == '5') {
            $sql .= " 
            order by penyesuain_stock.hpp_selisih_total " . $order_dir . " 
            ";
        }

        $totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");
        $sql .= "limit " . intval($start) . "," . intval($limit) . " ";
        $data = $this->db->query($sql);


        return array(
            'data' => $data->result_array(),
            'totalrows' => $totalrows->row_array()['totalrows']
        );
    }

    function detail($id_penyesuaian_stock)
    {

        $sql = "SELECT penyesuain_stock.id_penyesuaian_stock,
                date_format(penyesuain_stock.tanggal,'%d/%m/%Y %H:%i') AS `tanggal`,
                penyesuain_stock.id_users,
                penyesuain_stock.hpp_selisih_total,
                penyesuain_stock.keterangan,
                users.username
                FROM penyesuain_stock
                LEFT JOIN users ON users.id_users=penyesuain_stock.id_users
                WHERE
                penyesuain_stock.id_penyesuaian_stock=" . $this->db->escape($id_penyesuaian_stock) . " ";

        $db = $this->db->query($sql);

        $db = $this->db->query($sql);
        if ($db->num_rows() > 0) {
            return $db->row_array();
        } else {
            return false;
        }
    }
}
