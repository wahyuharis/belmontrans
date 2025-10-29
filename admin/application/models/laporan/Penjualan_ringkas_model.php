<?php
class Penjualan_ringkas_model extends CI_Model
{

    function total_penjualan($tanggal_start, $tanggal_end, $id_customer)
    {


        $sql = "SELECT 
                SUM(penjualan_detail.sub) AS total_penjualan
                FROM penjualan
                JOIN penjualan_detail ON penjualan_detail.id_penjualan=penjualan.id_penjualan
                WHERE 
                penjualan.deleted=0 ";

        if (!empty($id_supplier)) {
            $sql .=  " AND penjualan.id_customer=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= "  AND (penjualan.tanggal BETWEEN  '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";

        // print_r2($sql);

        $db = $this->db->query($sql);
        $total_pembelian = $db->row_array()['total_penjualan'];

        return $total_pembelian;
    }

    function jml_transaksi($tanggal_start, $tanggal_end, $id_customer)
    {
        $sql = "SELECT 
                COUNT(*) AS jml_transaksi
                FROM penjualan
                WHERE penjualan.deleted=0 ";

        if (!empty($id_supplier)) {
            $sql .=  " and penjualan.id_customer=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (penjualan.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";
        // print_r2($sql);

        $db = $this->db->query($sql);
        $jml_transaksi = $db->row_array()['jml_transaksi'];

        return $jml_transaksi;
    }

    function chart_harian($tanggal_start, $tanggal_end, $id_customer)
    {
        $sql = "  SELECT 
			        DATE(penjualan.tanggal) AS tanggal,
                    SUM(penjualan_detail.sub) AS total  
                FROM penjualan
                    JOIN penjualan_detail ON penjualan_detail.id_penjualan=penjualan.id_penjualan
                WHERE 
                    penjualan.deleted=0 ";

        if (!empty($id_supplier)) {
            $sql .=  " and penjualan.id_customer=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (penjualan.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";


        $sql .=  " GROUP BY date(penjualan.tanggal)";

        $db = $this->db->query($sql);
        $chart_harian = $db->result_array();

        return $chart_harian;
    }

    function chart_bulanan($tanggal_start, $tanggal_end, $id_customer)
    {
        $sql = "  SELECT 
						monthname(penjualan.tanggal) AS bulan,
                        SUM(penjualan_detail.sub) AS total  
                        FROM penjualan
                        right JOIN penjualan_detail ON penjualan_detail.id_penjualan=penjualan.id_penjualan
                        WHERE 
                        penjualan.deleted=0
                       ";

        if (!empty($id_supplier)) {
            $sql .=  " and penjualan.id_customer=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (penjualan.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";


        $sql .=  "  GROUP BY month(penjualan.tanggal) ";

        $db = $this->db->query($sql);
        $chart_harian = $db->result_array();

        return $chart_harian;
    }
}
