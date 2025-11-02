<?php
class Pembelian_retur_ringkas_model extends CI_Model
{

    function total_pembelian_retur($tanggal_start, $tanggal_end, $id_supplier)
    {


        $sql = "SELECT 
                SUM(pembelian_retur_detail.sub) AS total_pembelian_retur
                FROM pembelian_retur
                JOIN pembelian_retur_detail ON pembelian_retur_detail.id_pembelian_retur=pembelian_retur.id_pembelian_retur
                WHERE 
                pembelian_retur.deleted=0 ";

        if (!empty($id_supplier)) {
            $sql .=  " and pembelian_retur.id_supplier=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (pembelian_retur.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";

        // print_r2($sql);

        $db = $this->db->query($sql);
        $total_pembelian_retur = $db->row_array()['total_pembelian_retur'];

        return $total_pembelian_retur;
    }

    function jml_transaksi_retur($tanggal_start, $tanggal_end, $id_supplier)
    {
        $sql = "SELECT 
                COUNT(*) AS jml_transaksi
                FROM pembelian_retur
                WHERE pembelian_retur.deleted=0 ";

        if (!empty($id_supplier)) {
            $sql .=  " and pembelian_retur.id_supplier=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (pembelian_retur.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";
        // print_r2($sql);

        $db = $this->db->query($sql);
        $jml_transaksi = $db->row_array()['jml_transaksi'];

        return $jml_transaksi;
    }

    function chart_harian($tanggal_start, $tanggal_end, $id_supplier)
    {
        $sql = "SELECT 
                    DATE(pembelian_retur.tanggal) AS tanggal,
                    SUM(pembelian_retur_detail.sub) AS total  
                FROM pembelian_retur
                JOIN pembelian_retur_detail ON pembelian_retur_detail.id_pembelian_retur=pembelian_retur.id_pembelian_retur
                WHERE 
                    pembelian_retur.deleted=0 ";

        if (!empty($id_supplier)) {
            $sql .=  " and pembelian_retur.id_supplier=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (pembelian_retur.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";


        $sql .=  " GROUP BY date(pembelian_retur.tanggal)";

        $db = $this->db->query($sql);
        $chart_harian = $db->result_array();

        return $chart_harian;
    }

     function chart_bulanan($tanggal_start, $tanggal_end, $id_supplier)
    {
        $sql = "SELECT 
                    monthname(pembelian_retur.tanggal) AS bulan,
                    SUM(pembelian_retur_detail.sub) AS total  
                FROM pembelian_retur
                JOIN pembelian_retur_detail ON pembelian_retur_detail.id_pembelian_retur=pembelian_retur.id_pembelian_retur
                WHERE 
                    pembelian_retur.deleted=0
                       ";

        if (!empty($id_supplier)) {
            $sql .=  " and pembelian_retur.id_supplier=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (pembelian_retur.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";


        $sql .=  "  GROUP BY month(pembelian_retur.tanggal) ";

        $db = $this->db->query($sql);
        $chart_harian = $db->result_array();

        return $chart_harian;
    }
}