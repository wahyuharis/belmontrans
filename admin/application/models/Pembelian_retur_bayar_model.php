<?php
class Pembelian_retur_bayar_model extends CI_Model
{


    function bayar($id_pembelian_retur, $kode_bayar = "", $no_kwitansi = "", $tanggal, $id_rekening, $nominal_bayar)
    {
        $insert4['id_pembelian_retur'] = $id_pembelian_retur;
        $insert4['kode_bayar'] = $kode_bayar;
        $insert4['no_kwitansi'] = $no_kwitansi;
        $insert4['tanggal'] = $tanggal;
        $insert4['id_rekening'] = $id_rekening;
        $insert4['nominal_bayar'] = $nominal_bayar;

        $this->db->insert('pembelian_retur_bayar', $insert4);
        $insert_id = $this->db->insert_id();

        if (empty(trim($kode_bayar))) {
            $kode_bayar = "KBR" . str_pad($insert_id, 5, "0", STR_PAD_LEFT);

            $this->db->where('id_pembelian_retur_bayar', $insert_id);
            $this->db->update('pembelian_retur_bayar', array('kode_bayar' => $kode_bayar));
        }

        return $insert_id;
    }

    function get_list($id_pembelian_retur)
    {
        $sql = "SELECT 
		    pembelian_retur_bayar.id_pembelian_retur,
            pembelian_retur_bayar.kode_bayar,
            pembelian_retur_bayar.no_kwitansi,
            date_format(pembelian_retur_bayar.tanggal, '%d/%m/%Y') AS `tanggal`,
            m_rekening.nama_rekening,
            pembelian_retur_bayar.nominal_bayar
        FROM pembelian_retur_bayar
        LEFT JOIN m_rekening ON m_rekening.id_rekening=pembelian_retur_bayar.id_rekening
        WHERE pembelian_retur_bayar.id_pembelian_retur=".$this->db->escape($id_pembelian_retur)."
        ORDER BY pembelian_retur_bayar.id_pembelian_retur_bayar asc";

        $db = $this->db->query($sql);

        return $db->result_array();
    }
}
