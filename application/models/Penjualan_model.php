<?php
class Penjualan_model extends CI_Model
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
			penjualan.id_penjualan,
			'' AS `action`,
			penjualan.kode_penjualan,
		
			date_format(penjualan.tanggal,'%d/%m/%Y') AS `tanggal`,
			date_format(penjualan.jatuh_tempo,'%d/%m/%Y') AS `jatuh_tempo`,
			m_customer.nama_customer AS supplier,
			penjualan.total,
			penjualan_status_bayar(penjualan.id_penjualan) as `status`,
			penjualan_total_bayar(penjualan.id_penjualan) AS total_bayar,
			penjualan.id_customer
			FROM
			penjualan
			LEFT JOIN m_customer ON m_customer.id_customer=penjualan.id_customer
			WHERE penjualan.deleted=0
        ";

        if (strlen(in_get('kode_penjualan')) > 0) {
            $sql .= " and  penjualan.kode_penjualan like " . $this->db->escape(in_get('kode_penjualan')) . " ";
        }


        if (strlen(in_get('id_customer')) > 0) {
            $sql .= " and  m_customer.id_customer like " . $this->db->escape(in_get('id_customer')) . " ";
        }
        if (strlen($this->input->get('tanggal')) > 0 and strlen($this->input->get('tanggal2')) > 0) {
            $tanggal = $this->input->get('tanggal');
            $tanggal2 = $this->input->get('tanggal2');

            $tanggal = waktu_dmy_to_ymd($tanggal);
            $tanggal2 = waktu_dmy_to_ymd($tanggal2);

            $sql .= " and  (penjualan.tanggal between  '" . $this->db->escape_str($tanggal) . " 00:00:00' and '" . $this->db->escape_str($tanggal2) . " 23:59:59')";
        }

        if (strlen($this->input->get('jatuh_tempo')) > 0 and strlen($this->input->get('jatuh_tempo2')) > 0) {
            $jatuh_tempo = $this->input->get('jatuh_tempo');
            $jatuh_tempo2 = $this->input->get('jatuh_tempo2');

            $jatuh_tempo = waktu_dmy_to_ymd($jatuh_tempo);
            $jatuh_tempo2 = waktu_dmy_to_ymd($jatuh_tempo2);

            $sql .= " and  (penjualan.jatuh_tempo between  '" . $this->db->escape_str($jatuh_tempo) . " 00:00:00' and '" . $this->db->escape_str($jatuh_tempo2) . " 23:59:59')";
        }

        if (strlen($this->input->get('status')) > 0) {
            $status = $this->input->get('status');
            if ($status == 'lunas') {
                $sql .= " and  penjualan_status_bayar(penjualan.id_penjualan) = 2 ";
            }
            if ($status == 'parsial') {
                $sql .= " and penjualan_status_bayar(penjualan.id_penjualan) = 1 ";
            }
            if ($status == 'belum_lunas') {
                $sql .= " and penjualan_status_bayar(penjualan.id_penjualan) = 0 ";
            }
        }
        // $sql .= " order by pembelian.id_pembelian desc ";
        // print_r2($sql);
        if ($order_col == '0') {
            $sql .= " 
            order by penjualan.id_penjualan " . $order_dir . " 
            ";
        }

        if ($order_col == '2') {
            $sql .= " 
            order by penjualan.kode_penjualan " . $order_dir . " 
            ";
        }
        
        if ($order_col == '3') {
            $sql .= " 
            order by penjualan.tanggal " . $order_dir . " 
            ";
        }
        if ($order_col == '4') {
            $sql .= " 
            order by penjualan.jatuh_tempo " . $order_dir . " 
            ";
        }
        if ($order_col == '5') {
            $sql .= " 
            order by m_customer.nama_customer " . $order_dir . " 
            ";
        }
        if ($order_col == '6') {
            $sql .= " 
            order by penjualan.total " . $order_dir . " 
            ";
        }
        if ($order_col == '7') {
            $sql .= " 
            order by penjualan_status_bayar(penjualan.id_penjualan) " . $order_dir . " 
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

    function detail($id_penjualan)
	{
		$sql = "SELECT 
				penjualan.id_penjualan,
				penjualan.kode_penjualan,
				date_format(penjualan.tanggal,'%d/%m/%Y') AS `tanggal`,
				date_format(penjualan.jatuh_tempo,'%d/%m/%Y') AS `jatuh_tempo`,
				m_customer.nama_customer AS customer,
				penjualan.id_customer,
				penjualan.total_kotor,
				penjualan.ppn,
				penjualan.ppn_sub,
                penjualan.total,
				penjualan_total_bayar(penjualan.id_penjualan) AS total_bayar,
                penjualan_status_bayar(penjualan.id_penjualan) as status_bayar,
				penjualan.keterangan,
				penjualan.is_hutang,
				penjualan.bayar,
				penjualan.kembalian,
				penjualan.id_users
				FROM
				penjualan
				LEFT JOIN m_customer ON m_customer.id_customer=penjualan.id_customer
				WHERE penjualan.id_penjualan = " . $this->db->escape($id_penjualan) . " ";
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
			penjualan.kode_penjualan,
			date_format(penjualan.tanggal,'%d/%m/%Y') AS `tanggal`,
			m_customer.nama_customer AS customer,
			penjualan.total,
			penjualan_status_bayar(penjualan.id_penjualan)  AS `status`,
			( penjualan_total_bayar(penjualan.id_penjualan) ) AS total_bayar,
			penjualan.id_customer,
			penjualan.id_penjualan
			FROM
			penjualan
			LEFT JOIN m_customer ON m_customer.id_customer=penjualan.id_customer
			WHERE penjualan.deleted=0
			AND (
				penjualan.kode_penjualan LIKE '%" . $this->db->escape_str($search) . "%'
				or date_format(penjualan.tanggal,'%d/%m/%Y') LIKE '%" . $this->db->escape_str($search) . "%'
				or m_customer.nama_customer LIKE '%" . $this->db->escape_str($search) . "%'
			)
        ";

		$sql .= " order by penjualan.id_penjualan desc ";
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
