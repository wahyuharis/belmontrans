<?php
class Pembelian_ringkas_model extends CI_Model
{

    function total_pembelian($tanggal_start, $tanggal_end, $id_supplier)
    {


        $sql = "SELECT 
                SUM(pembelian_detail.sub) AS total_pembelian
                FROM pembelian
                JOIN pembelian_detail ON pembelian_detail.id_pembelian=pembelian.id_pembelian
                WHERE 
                pembelian.deleted=0 ";

        if (!empty($id_supplier)) {
            $sql .=  " and pembelian.id_supplier=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (pembelian.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";

        // print_r2($sql);

        $db = $this->db->query($sql);
        $total_pembelian = $db->row_array()['total_pembelian'];

        return $total_pembelian;
    }

    function jml_transaksi($tanggal_start, $tanggal_end, $id_supplier)
    {
        $sql = "SELECT 
                COUNT(*) AS jml_transaksi
                FROM pembelian
                WHERE pembelian.deleted=0 ";

        if (!empty($id_supplier)) {
            $sql .=  " and pembelian.id_supplier=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (pembelian.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";
        // print_r2($sql);

        $db = $this->db->query($sql);
        $jml_transaksi = $db->row_array()['jml_transaksi'];

        return $jml_transaksi;
    }

    function chart_harian($tanggal_start, $tanggal_end, $id_supplier)
    {
        $sql = "  SELECT 
			        DATE(pembelian.tanggal) AS tanggal,
                    SUM(pembelian_detail.sub) AS total  
                FROM pembelian
                    JOIN pembelian_detail ON pembelian_detail.id_pembelian=pembelian.id_pembelian
                WHERE 
                    pembelian.deleted=0 ";

        if (!empty($id_supplier)) {
            $sql .=  " and pembelian.id_supplier=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (pembelian.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";


        $sql .=  " GROUP BY date(pembelian.tanggal)";

        $db = $this->db->query($sql);
        $chart_harian = $db->result_array();

        return $chart_harian;
    }

    function chart_bulanan($tanggal_start, $tanggal_end, $id_supplier)
    {
        $sql = "  SELECT 
						monthname(pembelian.tanggal) AS bulan,
                        SUM(pembelian_detail.sub) AS total  
                        FROM pembelian
                        right JOIN pembelian_detail ON pembelian_detail.id_pembelian=pembelian.id_pembelian
                        WHERE 
                        pembelian.deleted=0
                       ";

        if (!empty($id_supplier)) {
            $sql .=  " and pembelian.id_supplier=" . $this->db->escape($id_supplier) . " ";
        }

        $sql .= " and (pembelian.tanggal between '" . $this->db->escape_str($tanggal_start) . " 00:00:00' and '" . $this->db->escape_str($tanggal_end) . " 23:59:59') ";


        $sql .=  "  GROUP BY month(pembelian.tanggal) ";

        $db = $this->db->query($sql);
        $chart_harian = $db->result_array();

        return $chart_harian;
    }
}
