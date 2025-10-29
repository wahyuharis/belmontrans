<?php
class Stock_hpp_model extends CI_Model
{

    function sql_list()
    {

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search_arr = $this->input->get('search');
        $search = trim($search_arr['value']);

        $order_arr = $this->input->get('order');
        $order_col = $this->db->escape_str($order_arr[0]['column']);
        $order_dir = $this->db->escape_str($order_arr[0]['dir']);


        $sql = "SELECT
                m_item.id_item,
                '' as `action`,
                
                m_item.nama_item,
                m_kategori.nama_kategori,
                stock_akhir(m_item.id_item) AS stock_akhir,
                stock_hpp(m_item.id_item) AS hpp,
                (stock_akhir(m_item.id_item) * stock_hpp(m_item.id_item)) AS total_hpp

                FROM m_item
                LEFT JOIN m_kategori ON m_item.id_kategori=m_kategori.id_kategori
                where
                m_item.deleted=0 and (
                    m_item.barcode like '%" . $this->db->escape_str($search) . "%'
                    or
                    m_item.nama_item like '%" . $this->db->escape_str($search) . "%'
                    or
                    m_kategori.nama_kategori like '%" . $this->db->escape_str($search) . "%'
                )

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
            order by stock_akhir(m_item.id_item) " . $order_dir . " 
            ";
        }
        if ($order_col == '5') {
            $sql .= " 
            order by stock_hpp(m_item.id_item) " . $order_dir . " 
            ";
        }

        if ($order_col == '6') {
            $sql .= " 
            order by (stock_akhir(m_item.id_item) * stock_hpp(m_item.id_item)) " . $order_dir . " 
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

    function detail($id_item)
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

            $filter_tanggal = "and (stock.waktu between  '" . $this->db->escape_str($tanggal) . " 00:00:00' and '" . $this->db->escape_str($tanggal2) . " 23:59:59')";
        }

        $sql = "SELECT 
            stock.id_stock, 
           date_format(stock.waktu,'%d/%m/%Y %H:%i:%s') AS waktu,
            stock.qty_awal,
            stock.qty_in,
            stock.qty_out,
            stock.qty_adj,
            stock.qty_akhir,
            stock.hpp,
            stock.hpptotal_awal,
            stock.hpptotal_in,
            stock.hpptotal_out,
            stock.hpptotal_akhir,
            stock.keterangan
            FROM stock WHERE stock.id_item=" . $this->db->escape($id_item) . "
            " . $filter_tanggal . "
        
            ORDER BY stock.id_stock desc ";


            // print_r2($sql);

        $this->db->query($sql);



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
