<?php
class Pembelian_retur_model extends CI_Model
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
			pembelian_retur.id_pembelian_retur,
			'' AS `action`,
			pembelian_retur.kode_pembelian_retur,
			pembelian.kode_pembelian,
			pembelian.no_invoice,
			date_format(pembelian_retur.tanggal,'%d/%m/%Y') AS `tanggal`,
			m_supplier.nama_supplier AS supplier,
			pembelian_retur.total,
			pembelian_retur_status_bayar(pembelian_retur.id_pembelian_retur) AS `status`,
			pembelian_retur_total_bayar(pembelian_retur.id_pembelian_retur) AS total_bayar,
			pembelian_retur.id_supplier
			FROM
			pembelian_retur
			LEFT JOIN m_supplier ON m_supplier.id_supplier=pembelian_retur.id_supplier
			LEFT JOIN pembelian ON pembelian.id_pembelian=pembelian_retur.id_pembelian
			WHERE pembelian_retur.deleted=0
        ";

		if (strlen(in_get('kode_pembelian_retur')) > 0) {
			$sql .= " and  pembelian_retur.kode_pembelian_retur like " . $this->db->escape(in_get('kode_pembelian_retur')) . " ";
		}

		if (strlen(in_get('kode_pembelian')) > 0) {
			$sql .= " and  pembelian.kode_pembelian like " . $this->db->escape(in_get('kode_pembelian')) . " ";
		}

		if (strlen(in_get('no_invoice')) > 0) {
			$sql .= " and  pembelian.no_invoice like " . $this->db->escape(in_get('no_invoice')) . " ";
		}

		if (strlen(in_get('id_supplier')) > 0) {
			$sql .= " and  m_supplier.id_supplier like " . $this->db->escape(in_get('id_supplier')) . " ";
		}
		if (strlen($this->input->get('tanggal')) > 0 and strlen($this->input->get('tanggal2')) > 0) {
			$tanggal = $this->input->get('tanggal');
			$tanggal2 = $this->input->get('tanggal2');

			$tanggal=waktu_dmy_to_ymd($tanggal);
			$tanggal2=waktu_dmy_to_ymd($tanggal2);

			$sql .= " and  (pembelian_retur.tanggal between  '".$this->db->escape_str($tanggal)." 00:00:00' and '".$this->db->escape_str($tanggal2)." 23:59:59')";
		}

		if (strlen($this->input->get('status')) > 0) {
			$status = $this->input->get('status');
			if ($status == 'lunas') {
				$sql .= " and pembelian_retur_status_bayar(pembelian_retur.id_pembelian_retur)=2 ";
			}
			if ($status == 'parsial') {
				$sql .= " and pembelian_retur_status_bayar(pembelian_retur.id_pembelian_retur)=1 ";
			}
			if ($status == 'belum_lunas') {
				$sql .= " and pembelian_retur_status_bayar(pembelian_retur.id_pembelian_retur)=0 ";
			}
		}
		// $sql .= " order by id_pembelian_retur desc ";
		// print_r2($sql);
		if ($order_col == '0') {
            $sql .= " 
            order by pembelian_retur.id_pembelian_retur " . $order_dir." 
            ";
        }
		if ($order_col == '2') {
            $sql .= " 
            order by pembelian_retur.kode_pembelian_retur " . $order_dir." 
            ";
        }
		if ($order_col == '3') {
            $sql .= " 
            order by pembelian.kode_pembelian " . $order_dir." 
            ";
        }
		if ($order_col == '4') {
            $sql .= " 
            order by pembelian.no_invoice " . $order_dir." 
            ";
        }
		if ($order_col == '5') {
            $sql .= " 
            order by pembelian_retur.tanggal " . $order_dir." 
            ";
        }
		if ($order_col == '6') {
            $sql .= " 
            order by m_supplier.nama_supplier " . $order_dir." 
            ";
        }
		if ($order_col == '7') {
            $sql .= " 
            order by pembelian_retur.total " . $order_dir." 
            ";
        }
		if ($order_col == '8') {
            $sql .= " 
            order by pembelian_retur_status_bayar(pembelian_retur.id_pembelian_retur) " . $order_dir." 
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

    function detail($id_pembelian_retur)
	{
		$sql = "SELECT 
                pembelian_retur.id_pembelian_retur,
                pembelian_retur.kode_pembelian_retur,
                pembelian.kode_pembelian,
                pembelian.no_invoice,
                date_format(pembelian_retur.tanggal,'%d/%m/%Y') AS `tanggal`,
                m_supplier.nama_supplier AS supplier,
                pembelian_retur.total,
                pembelian_retur_total_bayar(pembelian_retur.id_pembelian_retur) AS total_bayar,
                pembelian_retur_status_bayar(pembelian_retur.id_pembelian_retur) AS status_bayar,
                pembelian_retur.id_supplier,
                pembelian_retur.keterangan,
                pembelian_retur.is_hutang,
                pembelian_retur.bayar,
                pembelian_retur.kembalian,
                pembelian_retur.id_users
                FROM
                pembelian_retur
                LEFT JOIN m_supplier ON m_supplier.id_supplier=pembelian_retur.id_supplier
                LEFT JOIN pembelian ON pembelian.id_pembelian=pembelian_retur.id_pembelian
                WHERE pembelian_retur.id_pembelian_retur=" . $this->db->escape($id_pembelian_retur) . " ";

		$db = $this->db->query($sql);
		if ($db->num_rows() > 0) {
			return $db->row_array();
		} else {
			return false;
		}
	}
}