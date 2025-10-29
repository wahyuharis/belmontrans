<?php
class Penjualan_retur_ringkas_model extends CI_Model
{

    function total_pembelian_retur($tanggal_start, $tanggal_end, $id_customer)
    {


        $sql = "SELECT 
                SUM(penjualan_retur_detail.sub) AS total_penjualan_retur
                FROM penjualan_retur
                JOIN penjualan_retur_detail ON penjualan_retur_detail.id_penjualan_retur=penjualan_retur.id_penjualan_retur
                WHERE 
                penjualan_retur.deleted=0 ";

        if (!empty($id_customer)) {
            $sql .=  " and penjualan_retur.id_customer=" . $this->db->escape($id_customer) . " ";
        }

        $sql .= " and (penjualan_retur.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";

        // print_r2($sql);

        $db = $this->db->query($sql);
        $total_pembelian_retur = $db->row_array()['total_penjualan_retur'];

        return $total_pembelian_retur;
    }

    function jml_transaksi_retur($tanggal_start, $tanggal_end, $id_customer)
    {
        $sql = "SELECT 
                COUNT(*) AS jml_transaksi
                FROM penjualan_retur
                WHERE penjualan_retur.deleted=0 ";

        if (!empty($id_customer)) {
            $sql .=  " and penjualan_retur.id_customer=" . $this->db->escape($id_customer) . " ";
        }

        $sql .= " and (penjualan_retur.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";
        // print_r2($sql);

        $db = $this->db->query($sql);
        $jml_transaksi = $db->row_array()['jml_transaksi'];

        return $jml_transaksi;
    }

    function chart_harian($tanggal_start, $tanggal_end, $id_customer)
    {
        $sql = "SELECT 
                    DATE(penjualan_retur.tanggal) AS tanggal,
                    SUM(penjualan_retur_detail.sub) AS total  
                FROM penjualan_retur
                JOIN penjualan_retur_detail ON penjualan_retur_detail.id_penjualan_retur=penjualan_retur.id_penjualan_retur
                WHERE 
                    penjualan_retur.deleted=0 ";

        if (!empty($id_customer)) {
            $sql .=  " and penjualan_retur.id_customer=" . $this->db->escape($id_customer) . " ";
        }

        $sql .= " and (penjualan_retur.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";


        $sql .=  " GROUP BY date(penjualan_retur.tanggal)";

        $db = $this->db->query($sql);
        $chart_harian = $db->result_array();

        return $chart_harian;
    }

     function chart_bulanan($tanggal_start, $tanggal_end, $id_customer)
    {
        $sql = "SELECT 
                    monthname(penjualan_retur.tanggal) AS bulan,
                    SUM(penjualan_retur_detail.sub) AS total  
                FROM penjualan_retur
                JOIN penjualan_retur_detail ON penjualan_retur_detail.id_penjualan_retur=penjualan_retur.id_penjualan_retur
                WHERE 
                    penjualan_retur.deleted=0
                       ";

        if (!empty($id_customer)) {
            $sql .=  " and penjualan_retur.id_customer=" . $this->db->escape($id_customer) . " ";
        }

        $sql .= " and (penjualan_retur.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";


        $sql .=  "  GROUP BY month(penjualan_retur.tanggal) ";

        $db = $this->db->query($sql);
        $chart_harian = $db->result_array();

        return $chart_harian;
    }
}