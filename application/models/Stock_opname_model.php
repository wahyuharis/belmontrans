<?php
class Stock_opname_model extends CI_Model
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
            stock_opname.id_stock_opname,
            '' AS `action`,
            stock_opname.id_stock_opname as `ID`,
            date_format(stock_opname.tanggal,'%d/%m/%Y') AS `tanggal`,
            users.username,
            stock_opname.hpp_selisih_total
            FROM stock_opname
            LEFT JOIN users ON users.id_users=stock_opname.id_users

            where 
            date_format(stock_opname.tanggal,'%d/%m/%Y') like '%".$search_text."%'
            or
            users.username like '%".$search_text."%'
        ";


        if ($order_col == '0') {
            $sql .= " 
            order by stock_opname.id_stock_opname " . $order_dir . " 
            ";
        }

        if ($order_col == '2') {
            $sql .= " 
            order by stock_opname.id_stock_opname " . $order_dir . " 
            ";
        }

        if ($order_col == '3') {
            $sql .= " 
            order by stock_opname.tanggal " . $order_dir . " 
            ";
        }

        if ($order_col == '4') {
            $sql .= " 
            order by users.username " . $order_dir . " 
            ";
        }

        if ($order_col == '5') {
            $sql .= " 
            order by stock_opname.hpp_selisih_total " . $order_dir . " 
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


    function detail($id_stock_opname)
    {

        $sql = "SELECT 
                stock_opname.id_stock_opname,
                '' AS `action`,
                stock_opname.id_stock_opname,
                date_format(stock_opname.tanggal,'%d/%m/%Y') AS `tanggal`,
                users.username,
                stock_opname.hpp_selisih_total,
                stock_opname.keterangan
                FROM stock_opname
                LEFT JOIN users ON users.id_users=stock_opname.id_users
                WHERE stock_opname.id_stock_opname =" . $this->db->escape($id_stock_opname) . " ";

        $db = $this->db->query($sql);

        $db = $this->db->query($sql);
        if ($db->num_rows() > 0) {
            return $db->row_array();
        } else {
            return false;
        }
    }
}
