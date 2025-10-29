<?php

class M_item_model extends CI_Model
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
                '' AS `action`,
                m_item.nama_item,
                m_kategori.nama_kategori,
                m_item.harga_beli,
                m_item.harga_jual,
                stock_akhir(m_item.id_item) as stock_akhir,
                m_item.hitung_stock,
                m_item.satuan
                FROM m_item
                LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
                WHERE m_item.deleted =0 and (
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
        if ($order_col == '3') {
            $sql .= " 
            order by m_item.nama_item " . $order_dir . " 
            ";
        }
        if ($order_col == '4') {
            $sql .= " 
            order by m_kategori.nama_kategori " . $order_dir . " 
            ";
        }
        if ($order_col == '5') {
            $sql .= " 
            order by m_item.harga_beli " . $order_dir . " 
            ";
        }
        if ($order_col == '6') {
            $sql .= " 
            order by m_item.harga_jual " . $order_dir . " 
            ";
        }

        if ($order_col == '7') {
            $sql .= " 
            order by stock_akhir(m_item.id_item) " . $order_dir . " 
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

    function sql_detail($id_item)
    {
        $sql = "SELECT 
            m_item.id_item,
            m_item.barcode,
            m_item.nama_item,
            m_kategori.nama_kategori,
            m_item.satuan,
            m_item.harga_beli,
            m_item.harga_jual,
            m_item.hitung_stock,
            stock_akhir(m_item.id_item) AS stock_akhir,
            stock_hpp(m_item.id_item) AS hpp,
            m_item.keterangan
            FROM `m_item`
            LEFT JOIN `m_kategori` ON `m_kategori`.`id_kategori`=`m_item`.`id_kategori`
            WHERE `m_item`.`id_item` = " . $this->db->escape($id_item) . "";

        $db = $this->db->query($sql);

        return $db->row_array();
    }


    function sql_pembelian_modal()
    {

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search_arr = $this->input->get('search');
        $search = trim($search_arr['value']);

        $sql = "SELECT 
                '' AS `action`,
                m_item.barcode,
                m_item.nama_item,
                m_kategori.nama_kategori,
                m_item.harga_beli,
                m_item.harga_jual,
                stock_akhir(m_item.id_item) as `stock`,
                m_item.satuan,
                m_item.id_item,
                hitung_stock
                FROM m_item
                LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
                WHERE m_item.deleted =0 
                and m_item.hitung_stock =1
                and 
                (
                m_item.barcode like '%" . $this->db->escape_str($search) . "%'
                or
                m_item.nama_item like '%" . $this->db->escape_str($search) . "%'
                or
                m_kategori.nama_kategori like '%" . $this->db->escape_str($search) . "%'
                )
                ORDER BY m_item.id_item desc
                ";
        $totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");

        $sql .= "limit " . intval($start) . "," . intval($limit) . " ";
        $data = $this->db->query($sql);

        return array(
            'data' => $data->result_array(),
            'totalrows' => $totalrows->row_array()['totalrows']
        );
    }

    function sql_pembelian_detail($id_items)
    {

        $sql = "SELECT 
                m_item.*, 
                m_kategori.*,
                stock_akhir(m_item.id_item) as `stock`
            FROM m_item
            LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
            WHERE m_item.id_item=" . $this->db->escape($id_items) . " ";

        $db = $this->db->query($sql);

        if ($db->num_rows() > 0) {
            return $db->row_array();
        } else {
            return false;
        }
    }

    function sql_pembelian_barcode_detail($barcode)
    {
        $sql = "SELECT 
                m_item.*, 
                m_kategori.*,
                stock_akhir(m_item.id_item) as `stock`
            FROM m_item
            LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
            WHERE m_item.barcode=" . $this->db->escape($barcode) . " ";

        $db = $this->db->query($sql);

        if ($db->num_rows() > 0) {
            return $db->row_array();
        } else {
            return false;
        }
    }

    function sql_penjualan_modal()
    {

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search_arr = $this->input->get('search');
        $search = trim($search_arr['value']);

        $sql = "SELECT 
                '' AS `action`,
                m_item.barcode,
                m_item.nama_item,
                m_kategori.nama_kategori,
                m_item.harga_beli,
                m_item.harga_jual,
                stock_akhir(m_item.id_item) as `stock`,
                m_item.satuan,
                m_item.id_item,
                hitung_stock
                FROM m_item
                LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
                WHERE m_item.deleted =0 
                
                and 
                (
                m_item.barcode like '%" . $this->db->escape_str($search) . "%'
                or
                m_item.nama_item like '%" . $this->db->escape_str($search) . "%'
                or
                m_kategori.nama_kategori like '%" . $this->db->escape_str($search) . "%'
                )
                ORDER BY m_item.id_item desc
                ";
        $totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");

        $sql .= "limit " . intval($start) . "," . intval($limit) . " ";
        $data = $this->db->query($sql);

        return array(
            'data' => $data->result_array(),
            'totalrows' => $totalrows->row_array()['totalrows']
        );
    }

    function sql_penjualan_detail($id_items)
    {

        $sql = "SELECT 
                m_item.*, 
                m_kategori.*,
                stock_akhir(m_item.id_item) as `stock`,
                stock_hpp(m_item.id_item) as hpp
            FROM m_item
            LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
            WHERE m_item.id_item=" . $this->db->escape($id_items) . " ";

        $db = $this->db->query($sql);

        if ($db->num_rows() > 0) {
            return $db->row_array();
        } else {
            return false;
        }
    }

    function sql_penjualan_barcode_detail($barcode)
    {
        $sql = "SELECT 
                m_item.*, 
                m_kategori.*,
                stock_akhir(m_item.id_item) as `stock`,
                stock_hpp(m_item.id_item) as hpp
            FROM m_item
            LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
            WHERE m_item.barcode=" . $this->db->escape($barcode) . " ";

        $db = $this->db->query($sql);

        if ($db->num_rows() > 0) {
            return $db->row_array();
        } else {
            return false;
        }
    }

    function sql_penyesuaian_stock_modal()
    {

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search_arr = $this->input->get('search');
        $search = trim($search_arr['value']);

        $sql = "SELECT 
                '' AS `action`,
                m_item.barcode,
                m_item.nama_item,
                m_kategori.nama_kategori,
                m_item.harga_beli,
                m_item.harga_jual,
                stock_akhir(m_item.id_item) as `stock`,
                m_item.satuan,
                m_item.id_item,
                hitung_stock
                FROM m_item
                LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
                WHERE m_item.deleted =0 
                and m_item.hitung_stock =1
                and 
                (
                m_item.barcode like '%" . $this->db->escape_str($search) . "%'
                or
                m_item.nama_item like '%" . $this->db->escape_str($search) . "%'
                or
                m_kategori.nama_kategori like '%" . $this->db->escape_str($search) . "%'
                )
                ORDER BY m_item.id_item desc
                ";
        $totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");

        $sql .= "limit " . intval($start) . "," . intval($limit) . " ";
        $data = $this->db->query($sql);

        return array(
            'data' => $data->result_array(),
            'totalrows' => $totalrows->row_array()['totalrows']
        );
    }

    function sql_penyesuaian_stock_detail($id_items)
    {

        $sql = "SELECT 
                m_item.*, 
                m_kategori.*,
                stock_akhir(m_item.id_item) as `stock`,
                stock_hpp(m_item.id_item) as hpp
            FROM m_item
            LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
            WHERE m_item.id_item=" . $this->db->escape($id_items) . " ";

        $db = $this->db->query($sql);

        if ($db->num_rows() > 0) {
            return $db->row_array();
        } else {
            return false;
        }
    }

    function sql_penyesuaian_stock_barcode_detail($barcode)
    {
        $sql = "SELECT 
                m_item.*, 
                m_kategori.*,
                stock_akhir(m_item.id_item) as `stock`,
                stock_hpp(m_item.id_item) as hpp
            FROM m_item
            LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
            WHERE m_item.barcode=" . $this->db->escape($barcode) . " ";

        $db = $this->db->query($sql);

        if ($db->num_rows() > 0) {
            return $db->row_array();
        } else {
            return false;
        }
    }

    function sql_grosir_modal()
    {
        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search_arr = $this->input->get('search');
        $search = trim($search_arr['value']);

        $sql = "SELECT 
            '' AS `action`,
            m_item.nama_item,
            m_kategori.nama_kategori,
            stock_akhir(m_item.id_item) AS `stock`,
            A.barcode AS barcode_ecer,
            A.nama_item AS nama_item_ecer,
            stock_akhir(A.id_item) AS stock_ecer,
            m_item.id_item
            FROM m_item
            LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
            LEFT JOIN m_item A ON A.id_item=m_item.item_ecer
            WHERE 
            m_item.is_package=1
            and
            m_item.deleted=0
            order by m_item.id_item desc ";

        $totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");

        $sql .= "limit " . intval($start) . "," . intval($limit) . " ";
        $data = $this->db->query($sql);

        return array(
            'data' => $data->result_array(),
            'totalrows' => $totalrows->row_array()['totalrows']
        );
    }

    function sql_grosir_detail($id_item)
    {
        $sql = "SELECT 
            m_item.id_item,
            m_item.nama_item,
            m_item.qty_ecer,
            stock_akhir(m_item.id_item) AS `stock`,
            A.id_item AS id_item_ecer,
            A.nama_item AS nama_item_ecer
            FROM m_item
            LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
            LEFT JOIN m_item A ON A.id_item=m_item.item_ecer
            WHERE 
            m_item.is_package=1
            and
            m_item.id_item=" . $this->db->escape($id_item) . " ";

        $db = $this->db->query($sql);

        if ($db->num_rows() > 0) {
            return $db->row_array();
        } else {
            return false;
        }
    }
}
