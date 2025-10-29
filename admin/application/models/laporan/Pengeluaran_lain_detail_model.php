<?php
class Pengeluaran_lain_detail_model extends CI_Model
{

    function sql_list()
    {
        $start = $this->input->get('start');
        $limit = $this->input->get('length');

        $order_arr = $this->input->get('order');
        $order_col = $this->db->escape_str($order_arr[0]['column']);
        $order_dir = $this->db->escape_str($order_arr[0]['dir']);


        $filter_tanggal = '';
        if (strlen($this->input->get('tanggal')) > 0 and strlen($this->input->get('tanggal2')) > 0) {
            $tanggal = $this->input->get('tanggal');
            $tanggal2 = $this->input->get('tanggal2');

            $tanggal = waktu_dmy_to_ymd($tanggal);
            $tanggal2 = waktu_dmy_to_ymd($tanggal2);

            $filter_tanggal = "and (pengeluaran_lain.tanggal between  '" . $this->db->escape_str($tanggal) . " 00:00:00' and '" . $this->db->escape_str($tanggal2) . " 23:59:59')";
        }


        $filter_jenis_pengeluaran_lain = ' ';
        if (strlen(in_get('id_jenis_pengeluaran_lain')) > 0) {
            $filter_jenis_pengeluaran_lain = " and pengeluaran_lain.id_jenis_pengeluaran_lain like " . $this->db->escape(in_get('id_jenis_pengeluaran_lain')) . " ";
        }


        // print_r2($_GET);

        $sql = "SELECT  
                pengeluaran_lain.id_pengeluaran_lain,
                m_jenis_pengeluaran_lain.nama_jenis_pengeluaran_lain,
                SUM(pengeluaran_lain.nominal) AS total
                FROM pengeluaran_lain
                LEFT JOIN m_jenis_pengeluaran_lain on m_jenis_pengeluaran_lain.id_jenis_pengeluaran_lain=pengeluaran_lain.id_jenis_pengeluaran_lain
                WHERE 
                pengeluaran_lain.deleted=0
                ".$filter_tanggal."
                ".$filter_jenis_pengeluaran_lain."
                

                GROUP BY pengeluaran_lain.id_jenis_pengeluaran_lain
                ";



        if ($order_col == '0') {
            $sql .= " 
            order by pengeluaran_lain.id_jenis_pengeluaran_lain " . $order_dir . " 
            ";
        }
        if ($order_col == '1') {
            $sql .= " 
            order by m_jenis_pengeluaran_lain.nama_jenis_pengeluaran_lain " . $order_dir . " 
            ";
        }
        if ($order_col == '2') {
            $sql .= " 
            order by SUM(pengeluaran_lain.nominal) " . $order_dir . " 
            ";
        }

        // print_r2($sql);

        $totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");
        if (intval($limit) > 0) {
            $sql .= "limit " . intval($start) . "," . intval($limit) . " ";
        }
        $data = $this->db->query($sql);


        return array(
            'data' => $data->result_array(),
            'totalrows' => $totalrows->row_array()['totalrows'],
        );
    }
}
