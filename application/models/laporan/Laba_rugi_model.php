<?php
class Laba_rugi_model extends CI_Model
{

    function pemasukan_lain($tanggal1, $tanggal2)
    {
        $sql = "
        SELECT 
        m_jenis_pemasukan_lain.kode_jenis_pemasukan_lain,
        m_jenis_pemasukan_lain.nama_jenis_pemasukan_lain,
        (
        SELECT 
            sum(pemasukan_lain.nominal) 
            FROM pemasukan_lain WHERE 
            pemasukan_lain.deleted=0 
            AND 
            pemasukan_lain.id_jenis_pemasukan_lain=m_jenis_pemasukan_lain.id_jenis_pemasukan_lain
            AND pemasukan_lain.tanggal BETWEEN " . $this->db->escape($tanggal1) . " and " . $this->db->escape($tanggal2) . "
        ) AS total
        FROM m_jenis_pemasukan_lain
        WHERE m_jenis_pemasukan_lain.deleted=0
        ORDER BY m_jenis_pemasukan_lain.kode_jenis_pemasukan_lain asc
        ";

        $db = $this->db->query($sql);
        return $db->result_array();
    }

    function laba_kotor($tanggal1, $tanggal2)
    {
        $sql = "SELECT  
					( (COALESCE(tb.total_penjualan,0) - COALESCE(tb2.total_penjualan_retur,0)) - (COALESCE(tb.total_hpp_penjualan,0) - COALESCE(tb2.total_hpp_penjualan_retur,0)) ) AS profit
                FROM (
                        SELECT 
                        sum(penjualan_detail.qty) AS qty_penjualan,
                        sum(penjualan_detail.sub) AS total_penjualan,
                        sum(coalesce(penjualan_detail.qty,0) * coalesce(penjualan_detail.hpp,0)) AS total_hpp_penjualan
                        FROM penjualan
                        LEFT JOIN penjualan_detail ON penjualan_detail.id_penjualan=penjualan.id_penjualan
                        
                        WHERE penjualan.deleted=0
                        AND penjualan.tanggal BETWEEN " . $this->db->escape($tanggal1) . " AND " . $this->db->escape($tanggal2) . " 
                        
                        ) AS tb
                        cross join
                        (SELECT 
                        sum(penjualan_retur_detail.qty) AS qty_penjualan_retur,
                        sum(penjualan_retur_detail.sub) AS `total_penjualan_retur`,
                        SUM((coalesce(penjualan_retur_detail.qty,0) * coalesce(penjualan_retur_detail.hpp,0))) AS total_hpp_penjualan_retur
                        FROM penjualan_retur
                        LEFT JOIN penjualan_retur_detail ON penjualan_retur_detail.id_penjualan_retur=penjualan_retur.id_penjualan_retur
                        JOIN penjualan ON penjualan.id_penjualan=penjualan_retur.id_penjualan
                        
                        WHERE penjualan_retur.deleted=0
                        AND penjualan_retur.tanggal BETWEEN " . $this->db->escape($tanggal1) . " AND " . $this->db->escape($tanggal2) . " 
                        
                        ) AS tb2";

        $db = $this->db->query($sql);
        if ($db->num_rows() > 0) {
            return $db->row_array()['profit'];
        } else {
            return 0;
        }
    }

    function beban_penyesuaian_stock($tanggal1, $tanggal2)
    {
        $sql = "SELECT  
                SUM( penyesuaian_stock_detail.qty_selisih * penyesuaian_stock_detail.hpp ) AS beban_hpp

                FROM penyesuain_stock
                JOIN penyesuaian_stock_detail ON penyesuaian_stock_detail.id_penyesuaian_stock=penyesuain_stock.id_penyesuaian_stock

                WHERE 

                penyesuain_stock.tanggal BETWEEN " . $this->db->escape($tanggal1) . " AND " . $this->db->escape($tanggal2) . " ";

        $this->db->query($sql);

        $db = $this->db->query($sql);
        if ($db->num_rows() > 0) {
            return $db->row_array()['beban_hpp'];
        } else {
            return 0;
        }
    }

    function beban_stock_opname($tanggal1, $tanggal2)
    {
        $sql = "SELECT  
                SUM( stock_opname_detail.qty_selisih * stock_opname_detail.hpp ) AS beban_hpp

                FROM stock_opname
                JOIN stock_opname_detail ON stock_opname_detail.id_stock_opname =stock_opname.id_stock_opname

                WHERE 
                stock_opname.tanggal BETWEEN " . $this->db->escape($tanggal1) . " AND  " . $this->db->escape($tanggal2) . " ";

        $this->db->query($sql);

        $db = $this->db->query($sql);
        if ($db->num_rows() > 0) {
            return $db->row_array()['beban_hpp'];
        } else {
            return 0;
        }
    }

    function beban_pengeluaran_lain($tanggal1, $tanggal2)
    {
        $sql = "
        SELECT
        m_jenis_pengeluaran_lain.kode_jenis_pengeluaran_lain,
        m_jenis_pengeluaran_lain.nama_jenis_pengeluaran_lain,
        (
        SELECT 
            sum(pengeluaran_lain.nominal) 
            FROM pengeluaran_lain WHERE 
            pengeluaran_lain.deleted=0 
            AND 
            pengeluaran_lain.id_jenis_pengeluaran_lain=m_jenis_pengeluaran_lain.id_jenis_pengeluaran_lain
            AND pengeluaran_lain.tanggal between ".$this->db->escape($tanggal1)." and ".$this->db->escape($tanggal2)."
        ) AS total
        FROM
        m_jenis_pengeluaran_lain
        WHERE 
        m_jenis_pengeluaran_lain.deleted=0
        ORDER BY 
        m_jenis_pengeluaran_lain.kode_jenis_pengeluaran_lain asc
        ";
        $this->db->query($sql);

        $db = $this->db->query($sql);
        return $db->result_array();
    }
}
