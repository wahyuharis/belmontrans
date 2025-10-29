<?php
class M_rekening_model extends CI_Model
{
    function history_transaksi($id_rekening)
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

            $filter_tanggal = "and (cashflow.tanggal between  '" . $this->db->escape_str($tanggal) . " 00:00:00' and '" . $this->db->escape_str($tanggal2) . " 23:59:59')";
        }

        $sql = "SELECT 
                cashflow.id_cashflow,
                DATE_FORMAT(cashflow.tanggal,'%d/%m/%Y %H:%i:%s') AS tanggal,
                cashflow.tabel,
                (case when cashflow.tabel='pembelian' then
                (SELECT pembelian.kode_pembelian FROM pembelian LEFT JOIN pembelian_bayar ON pembelian_bayar.id_pembelian=pembelian.id_pembelian WHERE pembelian_bayar.id_pembelian_bayar=cashflow.id_trans LIMIT 1)
                when cashflow.tabel='pembelian_retur' then
                (SELECT pembelian_retur.kode_pembelian_retur FROM pembelian_retur LEFT JOIN pembelian_retur_bayar ON pembelian_retur_bayar.id_pembelian_retur=pembelian_retur.id_pembelian_retur WHERE pembelian_retur_bayar.id_pembelian_retur_bayar=cashflow.id_trans LIMIT 1)
                when cashflow.tabel='penjualan' then
                (SELECT penjualan.kode_penjualan FROM penjualan LEFT JOIN penjualan_bayar ON penjualan_bayar.id_penjualan=penjualan.id_penjualan WHERE penjualan_bayar.id_penjualan_bayar=cashflow.id_trans LIMIT 1)
                when cashflow.tabel='penjualan_retur' then
                (SELECT penjualan_retur.kode_penjualan_retur FROM penjualan_retur LEFT JOIN penjualan_retur_bayar ON penjualan_retur_bayar.id_penjualan_retur=penjualan_retur.id_penjualan_retur WHERE penjualan_retur_bayar.id_penjualan_retur_bayar=cashflow.id_trans LIMIT 1)
                when cashflow.tabel='pemasukan_lain' then
                (SELECT pemasukan_lain.kode_pemasukan_lain FROM pemasukan_lain WHERE pemasukan_lain.id_pemasukan_lain=cashflow.id_trans LIMIT 1)
                when cashflow.tabel='pengeluaran_lain' then
                (SELECT pengeluaran_lain.kode_pengeluaran_lain FROM pengeluaran_lain WHERE pengeluaran_lain.id_pengeluaran_lain=cashflow.id_trans LIMIT 1)
                when cashflow.tabel='kasbon' then
                (SELECT kasbon.kode_kasbon FROM kasbon WHERE kasbon.id_kasbon=cashflow.id_trans)
                when cashflow.tabel='kasbon_bayar' then
                (SELECT kasbon_bayar.kode_kasbon_bayar FROM kasbon_bayar WHERE kasbon_bayar.id_kasbon_bayar=cashflow.id_trans)

                ELSE ''
                END) AS kode_trans,

                cashflow.saldo_awal,
                cashflow.mutasi,
                cashflow.saldo_akhir,
                cashflow.keterangan

                FROM cashflow
                WHERE cashflow.id_rekening=" . $this->db->escape($id_rekening) . "
                ".$filter_tanggal."
                ORDER BY cashflow.id_cashflow desc 
                ";

        // print_r2($sql);

        $this->db->query($sql);



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
