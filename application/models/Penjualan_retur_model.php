<?php
class Penjualan_retur_model extends CI_Model
{

	function sql_list()
	{
		$start = $this->input->get('start');
		$limit = $this->input->get('length');

		$order_arr = $this->input->get('order');
        $order_col = $this->db->escape_str($order_arr[0]['column']);
        $order_dir = $this->db->escape_str($order_arr[0]['dir']);

		$sql = "
			SELECT 
            penjualan_retur.id_penjualan_retur,
            '' AS `action`,
            penjualan_retur.kode_penjualan_retur,
            penjualan.kode_penjualan,
            date_format(penjualan_retur.tanggal,'%d/%m/%Y') AS `tanggal`,
            m_customer.nama_customer AS customer,
            penjualan_retur.total,
            penjualan_retur_status_bayar(penjualan_retur.id_penjualan_retur) AS `status`,
            ( penjualan_retur_total_bayar(penjualan_retur.id_penjualan_retur) ) AS total_bayar,
            penjualan_retur.id_customer
            FROM
            penjualan_retur
            LEFT JOIN m_customer ON m_customer.id_customer=penjualan_retur.id_customer
            LEFT JOIN penjualan ON penjualan.id_penjualan=penjualan_retur.id_penjualan
            WHERE penjualan_retur.deleted=0
        ";

		

		if (strlen(in_get('kode_penjualan_retur')) > 0) {
			$sql .= " and  penjualan_retur.kode_penjualan_retur like " . $this->db->escape(in_get('kode_penjualan_retur')) . " ";
		}

		if (strlen(in_get('kode_penjualan')) > 0) {
			$sql .= " and  penjualan.kode_penjualan like " . $this->db->escape(in_get('kode_penjualan')) . " ";
		}


		if (strlen(in_get('id_customer')) > 0) {
			$sql .= " and  m_customer.id_customer like " . $this->db->escape(in_get	('id_customer')) . " ";
		}
		if (strlen($this->input->get('tanggal')) > 0 and strlen($this->input->get('tanggal2')) > 0) {
			$tanggal = $this->input->get('tanggal');
			$tanggal2 = $this->input->get('tanggal2');

			$tanggal=waktu_dmy_to_ymd($tanggal);
			$tanggal2=waktu_dmy_to_ymd($tanggal2);

			$sql .= " and  (penjualan_retur.tanggal between  '".$this->db->escape_str($tanggal)." 00:00:00' and '".$this->db->escape_str($tanggal2)." 23:59:59')";
		}

		if (strlen($this->input->get('status')) > 0) {
			$status = $this->input->get('status');
			if ($status == 'lunas') {
				$sql .= " and penjualan_retur_status_bayar(penjualan_retur.id_penjualan_retur) = 2 ";
			}
			if ($status == 'parsial') {
				$sql .= " and penjualan_retur_status_bayar(penjualan_retur.id_penjualan_retur) = 1 ";
			}
			if ($status == 'belum_lunas') {
				$sql .= " and penjualan_retur_status_bayar(penjualan_retur.id_penjualan_retur) = 0 ";
			}
		}
		// $sql .= " order by id_pembelian_retur desc ";

		// print_r2($sql);
		
		if ($order_col == '0') {
            $sql .= " 
            order by penjualan_retur.id_penjualan_retur " . $order_dir." 
            ";
        }
		if ($order_col == '2') {
            $sql .= " 
            order by penjualan_retur.kode_penjualan_retur " . $order_dir." 
            ";
        }
		if ($order_col == '3') {
            $sql .= " 
            order by penjualan.kode_penjualan " . $order_dir." 
            ";
        }

		if ($order_col == '4') {
            $sql .= " 
            order by penjualan_retur.tanggal " . $order_dir." 
            ";
        }
		if ($order_col == '5') {
            $sql .= " 
            order by m_customer.nama_customer " . $order_dir." 
            ";
        }
		if ($order_col == '6') {
            $sql .= " 
            order by penjualan_retur.total " . $order_dir." 
            ";
        }
		if ($order_col == '7') {
            $sql .= " 
            order by penjualan_retur_status_bayar(penjualan_retur.id_penjualan_retur) " . $order_dir." 
            ";
        }

		// print_r2($sql);

		$totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");
		$sql .= "limit " . intval($start) . "," . intval($limit) . " ";
		$data = $this->db->query($sql);


		return array(
			'data' => $data->result_array(),
			'totalrows' => $totalrows->row_array()['totalrows']
		);
	}

	function detail($id_penjualan_retur)
	{
		$sql = "SELECT 
		penjualan_retur.id_penjualan_retur,
		penjualan_retur.kode_penjualan_retur,
		penjualan.kode_penjualan,

		date_format(penjualan_retur.tanggal,'%d/%m/%Y') AS `tanggal`,
		m_customer.nama_customer AS customer,
		
		penjualan_retur.ppn,
		penjualan_retur.ppn_sub,
		penjualan_retur.total,
		penjualan_retur_total_bayar(penjualan_retur.id_penjualan_retur) AS total_bayar,
		penjualan_retur_status_bayar(penjualan_retur.id_penjualan_retur) AS `status_bayar`,
		penjualan_retur.id_customer,
		penjualan_retur.keterangan,
		penjualan_retur.is_hutang,
		penjualan_retur.bayar,
		penjualan_retur.kembalian,
		penjualan_retur.id_users
		FROM
		penjualan_retur
		LEFT JOIN m_customer ON m_customer.id_customer=penjualan_retur.id_customer
		LEFT JOIN penjualan ON penjualan.id_penjualan=penjualan_retur.id_penjualan
		WHERE penjualan_retur.id_penjualan_retur=" . $this->db->escape($id_penjualan_retur) . " ";

		$db = $this->db->query($sql);
		if ($db->num_rows() > 0) {
			return $db->row_array();
		} else {
			return false;
		}
	}
}