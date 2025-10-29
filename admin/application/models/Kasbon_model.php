<?php

class Kasbon_model extends CI_Model
{

    function detail($id_karyawan)
    {
        $sql = "
                SELECT * FROM (
					 SELECT 
                	  'utang' AS jenis,
                    kasbon.kode_kasbon AS kode,
                    date_format(kasbon.tanggal,'%d/%m/%Y') AS tanggal,
                    kasbon.nominal 
                FROM kasbon WHERE kasbon.id_karyawan=".$this->db->escape($id_karyawan)."
                    UNION ALL
                SELECT
					 		'bayar' AS jenis, 
                    kasbon_bayar.kode_kasbon_bayar AS kode,
                    date_format(kasbon_bayar.tanggal,'%d/%m/%Y') AS tanggal,
                    kasbon_bayar.jml_bayar AS nominal
                FROM 
                    kasbon_bayar WHERE kasbon_bayar.id_karyawan=".$this->db->escape($id_karyawan)." 
                  ) AS tb ORDER BY tanggal       
        
        ";

        $db = $this->db->query($sql);

        // print_r2($sql);

        return $db->result_array();
    }
}
