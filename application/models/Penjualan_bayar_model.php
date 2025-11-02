<?php
class Penjualan_bayar_model extends CI_Model
{


    function bayar($id_penjualan, $kode_bayar = "", $tanggal, $id_rekening, $nominal_bayar)
    {
        $insert4['id_penjualan'] = $id_penjualan;
        $insert4['kode_bayar'] = $kode_bayar;
        $insert4['tanggal'] = $tanggal;
        $insert4['id_rekening'] = $id_rekening;
        $insert4['nominal_bayar'] = $nominal_bayar;

        $this->db->insert('penjualan_bayar', $insert4);
        $insert_id = $this->db->insert_id();

        if (empty(trim($kode_bayar))) {
            $kode_bayar = "KJ" . str_pad($insert_id, 5, "0", STR_PAD_LEFT);

            $this->db->where('id_penjualan_bayar', $insert_id);
            $this->db->update('penjualan_bayar', array('kode_bayar' => $kode_bayar));
        }

        return $insert_id;
    }

    function get_list($id_penjualan)
    {
        $sql = "SELECT 
            penjualan_bayar.id_penjualan,
            penjualan_bayar.kode_bayar,
            date_format(penjualan_bayar.tanggal,'%d/%m/%Y') AS `tanggal`,
            m_rekening.nama_rekening,
            penjualan_bayar.nominal_bayar
            FROM penjualan_bayar
            LEFT JOIN m_rekening ON m_rekening.id_rekening=penjualan_bayar.id_rekening
            WHERE penjualan_bayar.id_penjualan=" . $this->db->escape($id_penjualan) . "
            order by penjualan_bayar.id_penjualan_bayar asc";

        $db = $this->db->query($sql);

        return $db->result_array();
    }
}
