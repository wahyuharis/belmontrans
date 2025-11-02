<?php

class Pengeluaran_lain_model extends CI_Model
{

    function sql_list()
    {

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        

        $order_arr = $this->input->get('order');
        $order_col = $this->db->escape_str($order_arr[0]['column']);
        $order_dir = $this->db->escape_str($order_arr[0]['dir']);


        $sql = "SELECT 
                pengeluaran_lain.id_pengeluaran_lain,
                    '' AS `action`,
                    pengeluaran_lain.kode_pengeluaran_lain,
                    DATE_FORMAT( pengeluaran_lain.tanggal,'%d/%m/%Y %H:%i:%s' ) AS tanggal,
                    m_jenis_pengeluaran_lain.nama_jenis_pengeluaran_lain,
                    pengeluaran_lain.nominal,
                    m_rekening.nama_rekening AS metode_pembayaran
                FROM pengeluaran_lain
                    LEFT JOIN m_jenis_pengeluaran_lain ON m_jenis_pengeluaran_lain.id_jenis_pengeluaran_lain=pengeluaran_lain.id_jenis_pengeluaran_lain
                    LEFT JOIN m_rekening ON m_rekening.id_rekening=pengeluaran_lain.id_rekening
                WHERE
                pengeluaran_lain.deleted = 0
                ";

       if (strlen($this->input->get('tanggal')) > 0 and strlen($this->input->get('tanggal2')) > 0) {
			$tanggal = $this->input->get('tanggal');
			$tanggal2 = $this->input->get('tanggal2');

			$tanggal=waktu_dmy_to_ymd($tanggal);
			$tanggal2=waktu_dmy_to_ymd($tanggal2);

			$sql .= " and  (pengeluaran_lain.tanggal between  '".$this->db->escape_str($tanggal)." 00:00:00' and '".$this->db->escape_str($tanggal2)." 23:59:59')";
		}

        if (strlen(in_get('id_jenis_pengeluaran_lain')) > 0) {
			$sql .= " and  pengeluaran_lain.id_jenis_pengeluaran_lain like " . $this->db->escape(in_get('id_jenis_pengeluaran_lain')) . " ";
		}

        if (strlen(in_get('nominal')) > 0) {
			$sql .= " and  pengeluaran_lain.nominal like " . $this->db->escape(in_get('nominal')) . " ";
		}

        
        if (strlen(in_get('kode_pengeluaran_lain')) > 0) {
			$sql .= " and  pengeluaran_lain.kode_pengeluaran_lain like " . $this->db->escape(in_get('kode_pengeluaran_lain')) . " ";
		}

        if (strlen(in_get('id_rekening')) > 0) {
            $sql .= " and  pengeluaran_lain.id_rekening like " . $this->db->escape(in_get('id_rekening')) . " ";
        }

        // print_r2($_GET);

        if ($order_col == '0') {
            $sql .= " 
            order by pengeluaran_lain.id_pengeluaran_lain " . $order_dir . " 
            ";
        }
        if ($order_col == '2') {
            $sql .= " 
            order by pengeluaran_lain.kode_pengeluaran_lain " . $order_dir . " 
            ";
        }
        if ($order_col == '3') {
            $sql .= " 
            order by pengeluaran_lain.tanggal " . $order_dir . " 
            ";
        }
        if ($order_col == '4') {
            $sql .= " 
            order by m_jenis_pengeluaran_lain.nama_jenis_pengeluaran_lain " . $order_dir . " 
            ";
        }
        if ($order_col == '5') {
            $sql .= " 
            order by pengeluaran_lain.nominal " . $order_dir . " 
            ";
        }

        if ($order_col == '6') {
            $sql .= " 
            order by m_rekening.nama_rekening " . $order_dir . " 
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
}
