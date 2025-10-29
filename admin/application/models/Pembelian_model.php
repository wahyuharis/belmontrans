<?php
class Pembelian_model extends CI_Model
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
			pembelian.id_pembelian,
			'' AS `action`,
			pembelian.kode_pembelian,
			pembelian.no_invoice,
			date_format(pembelian.tanggal,'%d/%m/%Y') AS `tanggal`,
			date_format(pembelian.jatuh_tempo,'%d/%m/%Y') AS `jatuh_tempo`,
			m_supplier.nama_supplier AS supplier,
			pembelian.total,
			pembelian_status_bayar(pembelian.id_pembelian) as `status`,
			pembelian_total_bayar(pembelian.id_pembelian) AS total_bayar,
			pembelian.id_supplier
			FROM
			pembelian
			LEFT JOIN m_supplier ON m_supplier.id_supplier=pembelian.id_supplier
			WHERE pembelian.deleted=0
        ";

		if (strlen(in_get('kode_pembelian')) > 0) {
			$sql .= " and  pembelian.kode_pembelian like " . $this->db->escape(in_get('kode_pembelian')) . " ";
		}

		if (strlen(in_get('no_invoice')) > 0) {
			$sql .= " and  pembelian.no_invoice like " . $this->db->escape(in_get('no_invoice')) . " ";
		}
		if (strlen(in_get('id_supplier')) > 0) {
			$sql .= " and  pembelian.id_supplier like " . $this->db->escape(in_get('id_supplier')) . " ";
		}
		if (strlen($this->input->get('tanggal')) > 0 and strlen($this->input->get('tanggal2')) > 0) {
			$tanggal = $this->input->get('tanggal');
			$tanggal2 = $this->input->get('tanggal2');

			$tanggal=waktu_dmy_to_ymd($tanggal);
			$tanggal2=waktu_dmy_to_ymd($tanggal2);

			$sql .= " and  (pembelian.tanggal between  '".$this->db->escape_str($tanggal)." 00:00:00' and '".$this->db->escape_str($tanggal2)." 23:59:59')";
		}

		if (strlen(in_get('jatuh_tempo')) > 0 and strlen(in_get('jatuh_tempo2')) > 0) {
			$jatuh_tempo = in_get('jatuh_tempo');
			$jatuh_tempo2 = in_get('jatuh_tempo2');

			$jatuh_tempo=waktu_dmy_to_ymd($jatuh_tempo);
			$jatuh_tempo2=waktu_dmy_to_ymd($jatuh_tempo2);

			$sql .= " and  (pembelian.jatuh_tempo between  '".$this->db->escape_str($jatuh_tempo)." 00:00:00' and '".$this->db->escape_str($jatuh_tempo2)." 23:59:59')";

		}

		if (strlen($this->input->get('status')) > 0) {
			$status = $this->input->get('status');
			if ($status == 'lunas') {
				$sql .= " and  pembelian_status_bayar(pembelian.id_pembelian) = 2 ";
			}
			if ($status == 'parsial') {
				$sql .= " and pembelian_status_bayar(pembelian.id_pembelian) = 1 ";
			}
			if ($status == 'belum_lunas') {
				$sql .= " and pembelian_status_bayar(pembelian.id_pembelian) = 0 ";
			}
		}
		// $sql .= " order by pembelian.id_pembelian desc ";
		// print_r2($sql);
		if ($order_col == '0') {
            $sql .= " 
            order by pembelian.id_pembelian " . $order_dir." 
            ";
        }

		if ($order_col == '2') {
            $sql .= " 
            order by pembelian.kode_pembelian " . $order_dir." 
            ";
        }
		if ($order_col == '3') {
            $sql .= " 
            order by pembelian.no_invoice " . $order_dir." 
            ";
        }
		if ($order_col == '4') {
            $sql .= " 
            order by pembelian.tanggal " . $order_dir." 
            ";
        }
		if ($order_col == '5') {
            $sql .= " 
            order by pembelian.jatuh_tempo " . $order_dir." 
            ";
        }
		if ($order_col == '6') {
            $sql .= " 
            order by m_supplier.nama_supplier " . $order_dir." 
            ";
        }
		if ($order_col == '7') {
            $sql .= " 
            order by pembelian.total " . $order_dir." 
            ";
        }
		if ($order_col == '8') {
            $sql .= " 
            order by pembelian_status_bayar(pembelian.id_pembelian) " . $order_dir." 
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


	function detail($id_pembelian)
	{
		$sql = "SELECT 
				pembelian.id_pembelian,
				pembelian.kode_pembelian,
				pembelian.no_invoice,
				date_format(pembelian.tanggal,'%d/%m/%Y') AS `tanggal`,
				date_format(pembelian.jatuh_tempo,'%d/%m/%Y') AS `jatuh_tempo`,
				m_supplier.nama_supplier AS supplier,
				pembelian.total,
				pembelian.id_supplier,
				pembelian_total_bayar(pembelian.id_pembelian) AS total_bayar,
				pembelian_status_bayar(pembelian.id_pembelian) AS status_bayar,
				pembelian.keterangan,
				pembelian.is_hutang,
				pembelian.bayar,
				pembelian.kembalian,
				pembelian.id_users
				FROM
				pembelian
				LEFT JOIN m_supplier ON m_supplier.id_supplier=pembelian.id_supplier
				WHERE pembelian.id_pembelian = " . $this->db->escape($id_pembelian) . " ";
		$db = $this->db->query($sql);
		if ($db->num_rows() > 0) {
			return $db->row_array();
		} else {
			return false;
		}
	}

	function sql_list_retur_modal()
	{
		$start = $this->input->get('start');
		$limit = $this->input->get('length');
		$search_arr = $this->input->get('search');
		$search = trim($search_arr['value']);

		$sql = "
			SELECT 
			'' AS `action`,
			pembelian.kode_pembelian,
			pembelian.no_invoice,
			date_format(pembelian.tanggal,'%d/%m/%Y') AS `tanggal`,
			m_supplier.nama_supplier AS supplier,
			pembelian.total,
			pembelian_status_bayar(pembelian.id_pembelian) AS `status_bayar`,
			pembelian_total_bayar(pembelian.id_pembelian) AS total_bayar,
			pembelian.id_supplier,
			pembelian.id_pembelian
			FROM
			pembelian
			LEFT JOIN m_supplier ON m_supplier.id_supplier=pembelian.id_supplier
			WHERE pembelian.deleted=0
			AND (
				pembelian.kode_pembelian LIKE '%" . $this->db->escape_str($search) . "%'
				or pembelian.no_invoice like '%" . $this->db->escape_str($search) . "%'
				or date_format(pembelian.tanggal,'%d/%m/%Y') LIKE '%" . $this->db->escape_str($search) . "%'
				or m_supplier.nama_supplier LIKE '%" . $this->db->escape_str($search) . "%'
			)
        ";

		$sql .= " order by pembelian.id_pembelian desc ";
		// print_r2($sql);

		$totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");
		$sql .= "limit " . intval($start) . "," . intval($limit) . " ";
		$data = $this->db->query($sql);


		return array(
			'data' => $data->result_array(),
			'totalrows' => $totalrows->row_array()['totalrows']
		);
	}

}
