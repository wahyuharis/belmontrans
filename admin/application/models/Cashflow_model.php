<?php
class Cashflow_model extends CI_Model
{

    function saldo_akhir($id_rekening)
    {
        $sql = "SELECT cashflow_saldo_akhir(" . $this->db->escape($id_rekening) . ") AS saldo_akhir";
        $db = $this->db->query($sql);

        $saldo_akhir = 0;
        if ($db->num_rows() > 0) {
            $saldo_akhir = $db->row_array()['saldo_akhir'];
            $saldo_akhir = doubleval($saldo_akhir);
        }

        return $saldo_akhir;
    }

    function saldo_awal($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'm_rekening';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "SALDO AWAL";

        $this->db->insert('cashflow', $insert);
    }

    function perbaikan_saldo($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'm_rekening';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "PERBAIKAN SALDO";

        $this->db->insert('cashflow', $insert);
    }

    function pembelian($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'pembelian';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "PEMBELIAN";

        $this->db->insert('cashflow', $insert);
    }

    function delete_pembelian($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'pembelian';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "DELETE PEMBELIAN";

        $this->db->insert('cashflow', $insert);
    }


    function pembelian_retur($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'pembelian_retur';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "RETUR PEMBELIAN";

        $this->db->insert('cashflow', $insert);
    }

    function delete_pembelian_retur($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'pembelian_retur';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "DELETE RETUR PEMBELIAN";

        $this->db->insert('cashflow', $insert);
    }

    function penjualan($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'penjualan';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "PENJUALAN";

        $this->db->insert('cashflow', $insert);
    }

    function delete_penjualan($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'penjualan';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "DELETE PENJUALAN";

        $this->db->insert('cashflow', $insert);
    }

    function penjualan_retur($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'penjualan_retur';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "RETUR PENJUALAN";

        $this->db->insert('cashflow', $insert);
    }

    function delete_penjualan_retur($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'penjualan_retur';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "DELETE RETUR PENJUALAN";

        $this->db->insert('cashflow', $insert);
    }

    function pemasukan_lain($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'pemasukan_lain';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "PEMASUKAN LAIN";

        $this->db->insert('cashflow', $insert);
    }
    function delete_pemasukan_lain($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'pemasukan_lain';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "DELETE PEMASUKAN LAIN";

        $this->db->insert('cashflow', $insert);
    }

    function pengeluaran_lain($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'pengeluaran_lain';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "PENGELUARAN LAIN";

        $this->db->insert('cashflow', $insert);
    }

    function delete_pengeluaran_lain($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'pemasukan_lain';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "DELETE PENGELUARAN LAIN";

        $this->db->insert('cashflow', $insert);
    }

    function kasbon($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'kasbon';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "KASBON";

        $this->db->insert('cashflow', $insert);
    }

    function delete_kasbon($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'kasbon';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "DELETE KASBON";

        $this->db->insert('cashflow', $insert);
    }

    function kasbon_bayar($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'kasbon_bayar';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "BAYAR KASBON";

        $this->db->insert('cashflow', $insert);
    }


    function delete_kasbon_bayar($id_trans, $tanggal, $id_rekening, $mutasi)
    {
        $insert['tabel'] = 'kasbon_bayar';
        $insert['id_trans'] = $id_trans;
        $insert['tanggal'] = $tanggal;
        $insert['id_rekening'] = $id_rekening;
        $insert['saldo_awal'] = $this->saldo_akhir($id_rekening);
        $insert['mutasi'] = $mutasi;
        $insert['saldo_akhir'] = $insert['saldo_awal'] + $insert['mutasi'];
        $insert['keterangan'] = "DELETE BAYAR KASBON";

        $this->db->insert('cashflow', $insert);
    }
}
