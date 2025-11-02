<?php
class Pembelian_bayar_model extends CI_Model
{


    function bayar($id_pembelian, $kode_bayar = "", $no_kwitansi = "", $tanggal, $id_rekening, $nominal_bayar)
    {
        $insert4['id_pembelian'] = $id_pembelian;
        $insert4['kode_bayar'] = $kode_bayar;
        $insert4['no_kwitansi'] = $no_kwitansi;
        $insert4['tanggal'] = $tanggal;
        $insert4['id_rekening'] = $id_rekening;
        $insert4['nominal_bayar'] = $nominal_bayar;

        $this->db->insert('pembelian_bayar', $insert4);
        $insert_id = $this->db->insert_id();

        if (empty(trim($kode_bayar))) {
            $kode_bayar = "KB" . str_pad($insert_id, 5, "0", STR_PAD_LEFT);

            $this->db->where('id_pembelian_bayar', $insert_id);
            $this->db->update('pembelian_bayar', array('kode_bayar' => $kode_bayar));
        }

        return $insert_id;
    }

    function get_list($id_pembelian)
    {
        $sql = "SELECT 
            pembelian_bayar.id_pembelian,
            pembelian_bayar.kode_bayar,
            pembelian_bayar.no_kwitansi,
            date_format(pembelian_bayar.tanggal,'%d/%m/%Y') AS `tanggal`,
            m_rekening.nama_rekening,
            pembelian_bayar.nominal_bayar
            FROM pembelian_bayar
            LEFT JOIN m_rekening ON m_rekening.id_rekening=pembelian_bayar.id_rekening
            WHERE pembelian_bayar.id_pembelian=" . $this->db->escape($id_pembelian) . "
            order by pembelian_bayar.id_pembelian_bayar asc";

        $db = $this->db->query($sql);

        return $db->result_array();
    }
}
