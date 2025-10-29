<?php
class Penjualan_retur_bayar_model extends CI_Model
{

    function bayar($id_penjualan_retur, $kode_bayar = "",$no_kwitansi = "", $tanggal, $id_rekening, $nominal_bayar)
    {
        $insert4['id_penjualan_retur'] = $id_penjualan_retur;
        $insert4['kode_bayar'] = $kode_bayar;
        $insert4['no_kwitansi'] = $no_kwitansi;
        $insert4['tanggal'] = $tanggal;
        $insert4['id_rekening'] = $id_rekening;
        $insert4['nominal_bayar'] = $nominal_bayar;

        $this->db->insert('penjualan_retur_bayar', $insert4);
        $insert_id = $this->db->insert_id();

        if (empty(trim($kode_bayar))) {
            $kode_bayar = "KJR" . str_pad($insert_id, 5, "0", STR_PAD_LEFT);

            $this->db->where('id_penjualan_retur_bayar', $insert_id);
            $this->db->update('penjualan_retur_bayar', array('kode_bayar' => $kode_bayar));
        }

        return $insert_id;
    }


    function get_list($id_penjualan_retur)
    {
        $sql = "SELECT 
            penjualan_retur_bayar.id_penjualan_retur,
            penjualan_retur_bayar.kode_bayar,
            penjualan_retur_bayar.no_kwitansi,
            date_format(penjualan_retur_bayar.tanggal,'%d/%m/%Y') AS `tanggal`,
            m_rekening.nama_rekening,
            penjualan_retur_bayar.nominal_bayar
            FROM penjualan_retur_bayar
            LEFT JOIN m_rekening ON m_rekening.id_rekening=penjualan_retur_bayar.id_rekening
            WHERE penjualan_retur_bayar.id_penjualan_retur=".$this->db->escape($id_penjualan_retur)."
            order by penjualan_retur_bayar.id_penjualan_retur_bayar asc";

        $db = $this->db->query($sql);

        return $db->result_array();
    }

}
