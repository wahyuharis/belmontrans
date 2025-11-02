<?php
class Laba_kotor_ringkas_model extends CI_Model
{

    function sales_cogs_profit($tanggal_start, $tanggal_end)
    {


        $sql = "SELECT  
                ( COALESCE(tb.qty_penjualan,0)-COALESCE(tb2.qty_penjualan_retur,0) ) AS qty_fix,
                ( COALESCE(tb.total_penjualan,0) - COALESCE(tb2.total_penjualan_retur,0) ) AS sales,
                (COALESCE(tb.total_hpp_penjualan,0) - COALESCE(tb2.total_hpp_penjualan_retur,0) ) AS cogs,
                ( (COALESCE(tb.total_penjualan,0) - COALESCE(tb2.total_penjualan_retur,0)) - (COALESCE(tb.total_hpp_penjualan,0) - COALESCE(tb2.total_hpp_penjualan_retur,0)) ) AS provit
                FROM (
                        SELECT 
                        sum(penjualan_detail.qty) AS qty_penjualan,
                        sum(penjualan_detail.sub) AS total_penjualan,
                        sum(coalesce(penjualan_detail.qty,0) * coalesce(penjualan_detail.hpp,0)) AS total_hpp_penjualan
                        FROM penjualan
                        LEFT JOIN penjualan_detail ON penjualan_detail.id_penjualan=penjualan.id_penjualan
                        
                        WHERE penjualan.deleted=0
                        AND penjualan.tanggal BETWEEN ".$this->db->escape($tanggal_start)." AND ".$this->db->escape($tanggal_end)." 
                        
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
                        AND penjualan_retur.tanggal BETWEEN ".$this->db->escape($tanggal_start)." AND ".$this->db->escape($tanggal_end)."
                        
                        ) AS tb2";

        $db = $this->db->query($sql);
        $sales = $db->row_array()['sales'];
        $cogs = $db->row_array()['cogs'];
        $profit = $db->row_array()['provit'];


        $return=array(
            'sales'=>$sales,
            'cogs'=>$cogs,
            'profit'=>$profit
        );

        return $return;
    }


    function chart_harian($tanggal_start, $tanggal_end)
    {
        $sql = "SELECT  
                tb.tanggal_penjualan,
                ( COALESCE(tb.qty_penjualan,0)-COALESCE(tb2.qty_penjualan_retur,0) ) AS qty_fix,
                ( COALESCE(tb.total_penjualan,0) - COALESCE(tb2.total_penjualan_retur,0) ) AS sales,
                (COALESCE(tb.total_hpp_penjualan,0) - COALESCE(tb2.total_hpp_penjualan_retur,0) ) AS cogs,
                ( (COALESCE(tb.total_penjualan,0) - COALESCE(tb2.total_penjualan_retur,0)) - (COALESCE(tb.total_hpp_penjualan,0) - COALESCE(tb2.total_hpp_penjualan_retur,0)) ) AS provit
                FROM (
                        SELECT 
                        date(penjualan.tanggal) AS tanggal_penjualan,
                        sum(penjualan_detail.qty) AS qty_penjualan,
                        sum(penjualan_detail.sub) AS total_penjualan,
                        sum(coalesce(penjualan_detail.qty,0) * coalesce(penjualan_detail.hpp,0)) AS total_hpp_penjualan
                        FROM penjualan
                        LEFT JOIN penjualan_detail ON penjualan_detail.id_penjualan=penjualan.id_penjualan
                        
                        WHERE penjualan.deleted=0
                        AND penjualan.tanggal BETWEEN ".$this->db->escape($tanggal_start)." AND ".$this->db->escape($tanggal_end)." 
                        
                        GROUP BY date(penjualan.tanggal)
                        ) AS tb
                        LEFT join
                        (SELECT 
                        
                        date(penjualan.tanggal) AS tanggal_retur,
                        sum(penjualan_retur_detail.qty) AS qty_penjualan_retur,
                        sum(penjualan_retur_detail.sub) AS `total_penjualan_retur`,
                        SUM((coalesce(penjualan_retur_detail.qty,0) * coalesce(penjualan_retur_detail.hpp,0))) AS total_hpp_penjualan_retur
                        FROM penjualan_retur
                        LEFT JOIN penjualan_retur_detail ON penjualan_retur_detail.id_penjualan_retur=penjualan_retur.id_penjualan_retur
                        JOIN penjualan ON penjualan.id_penjualan=penjualan_retur.id_penjualan
                        
                        WHERE penjualan_retur.deleted=0
                        AND penjualan_retur.tanggal BETWEEN ".$this->db->escape($tanggal_start)." AND ".$this->db->escape($tanggal_end)." 
                        
                        GROUP BY date(penjualan.tanggal)
                        ) AS tb2 ON tb2.tanggal_retur=tb.tanggal_penjualan";

        $db = $this->db->query($sql);
        $chart_harian = $db->result_array();

        return $chart_harian;
    }

    function chart_bulanan($tanggal_start, $tanggal_end)
    {
        $sql = "SELECT 
                tb3.bulan,
                tb3.bulan_id, 
                tb3.qty_fix,
                tb3.sales,
                tb3.cogs,
                (coalesce(tb3.sales,0) - COALESCE(tb3.cogs,0)) AS provit
                FROM (
                SELECT 
                tb.bulan, 
                tb.bulan_id,
                ( COALESCE(tb.qty_penjualan,0) - COALESCE(tb2.qty_penjualan_retur,0) ) AS qty_fix,
                ( COALESCE(tb.total_penjualan,0) - COALESCE(tb2.total_penjualan_retur,0) ) AS sales,
                ( COALESCE(tb.total_hpp_penjualan,0) - COALESCE(tb2.total_hpp_penjualan_retur,0) ) AS cogs
                FROM
                        (SELECT 
                        MONTHNAME(penjualan.tanggal) AS bulan,
                        MONTH(penjualan.tanggal) AS bulan_id,
                        sum(penjualan_detail.qty) AS qty_penjualan,
                        sum(penjualan_detail.sub) AS total_penjualan,
                        SUM( coalesce(penjualan_detail.qty,0) * coalesce(penjualan_detail.hpp,0) ) AS total_hpp_penjualan
                        FROM penjualan
                        LEFT JOIN penjualan_detail ON penjualan_detail.id_penjualan=penjualan.id_penjualan
                        
                        WHERE penjualan.deleted=0
                        AND penjualan.tanggal BETWEEN ".$this->db->escape($tanggal_start)." AND ".$this->db->escape($tanggal_end)." 
                        
                        GROUP BY MONTH(penjualan.tanggal)
                        ) AS tb
                        LEFT join
                        (SELECT 
                        MONTHNAME(penjualan.tanggal) AS bulan,
                        MONTH(penjualan.tanggal) AS bulan_id,
                        sum(penjualan_retur_detail.qty) AS qty_penjualan_retur,
                        sum(penjualan_retur_detail.sub) AS `total_penjualan_retur`,
                        SUM(( coalesce(penjualan_retur_detail.qty,0) * coalesce(penjualan_retur_detail.hpp,0) )) AS total_hpp_penjualan_retur
                        FROM penjualan_retur
                        LEFT JOIN penjualan_retur_detail ON penjualan_retur_detail.id_penjualan_retur=penjualan_retur.id_penjualan_retur
                        JOIN penjualan ON penjualan.id_penjualan=penjualan_retur.id_penjualan
                        
                        WHERE penjualan_retur.deleted=0
                        AND penjualan_retur.tanggal BETWEEN ".$this->db->escape($tanggal_start)." AND ".$this->db->escape($tanggal_end)." 
                        
                        GROUP BY MONTH(penjualan.tanggal)
                        ) AS tb2 ON tb2.bulan_id=tb.bulan_id
                ) AS tb3";

        $db = $this->db->query($sql);
        $chart_harian = $db->result_array();

        return $chart_harian;
    }
}
