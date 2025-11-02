<?php
class Stock_model extends CI_Model
{

    function stock_akhir($id_item)
    {
        $sql = "SELECT stock_akhir(" . $this->db->escape($id_item) . ") as qty_akhir";

        $db = $this->db->query($sql);

        $stock_akhir = 0;
        if ($db->num_rows() > 0) {
            $stock_akhir = $db->row_array()['qty_akhir'];
            $stock_akhir = doubleval($stock_akhir);
        }

        return $stock_akhir;
    }

    function stock_hpp($id_item)
    {
        $sql = "SELECT stock_hpp(" . $this->db->escape($id_item) . ") as hpp";

        $db = $this->db->query($sql);

        $hpp = 0;
        if ($db->num_rows() > 0) {
            $hpp = $db->row_array()['hpp'];
            $hpp = doubleval($hpp);
        }

        return $hpp;
    }

    function hpptotal_akhir($id_item)
    {
        $sql = "SELECT hpptotal_akhir 
        FROM stock 
        WHERE stock.id_item=" . $this->db->escape($id_item) . " 
        ORDER BY stock.id_stock desc";
        $db = $this->db->query($sql);

        $hpptotal_akhir = 0;
        if ($db->num_rows() > 0) {
            $hpptotal_akhir = $db->row_array()['hpptotal_akhir'];
            $hpptotal_akhir = doubleval($hpptotal_akhir);
        }

        return $hpptotal_akhir;
    }

    function stock_pembelian($waktu, $id_item, $qty, $hpp, $hpptotal_in)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'pembelian';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_in'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] + $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_in'] = $hpptotal_in;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] + $hpptotal_in;
            $insert['keterangan'] = "Pembelian";

            $this->db->insert('stock', $insert);
        }
    }

    function stock_pembelian_delete($waktu, $id_item, $qty, $hpp, $hpptotal_out)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'pembelian_delete';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_out'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] - $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_out'] = $hpptotal_out;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] - $hpptotal_out;
            $insert['keterangan'] = "Delete Pembelian";

            $this->db->insert('stock', $insert);
        }
    }

    function stock_retur_pembelian($waktu, $id_item, $qty, $hpp, $hpptotal_out)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'pembelian_retur';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_out'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] - $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_out'] = $hpptotal_out;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] - $hpptotal_out;
            $insert['keterangan'] = "Retur Pembelian";

            $this->db->insert('stock', $insert);
        }
    }

    function stock_retur_pembelian_delete($waktu, $id_item, $qty, $hpp, $hpptotal_in)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'pembelian_retur_delete';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_in'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] + $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_in'] = $hpptotal_in;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] + $hpptotal_in;
            $insert['keterangan'] = "Delete Retur Pembelian";

            $this->db->insert('stock', $insert);
        }
    }

    function stock_penjualan($waktu, $id_item, $qty, $hpp, $hpptotal_out)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'penjualan';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_out'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] - $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_out'] = $hpptotal_out;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] - $hpptotal_out;
            $insert['keterangan'] = "Penjualan";

            $this->db->insert('stock', $insert);
        }
    }

    function stock_penjualan_delete($waktu, $id_item, $qty, $hpp, $hpptotal_in)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'penjualan_delete';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_in'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] + $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_in'] = $hpptotal_in;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] + $hpptotal_in;
            $insert['keterangan'] = "Delete Penjualan";

            $this->db->insert('stock', $insert);
        }
    }


    function stock_penjualan_retur($waktu, $id_item, $qty, $hpp, $hpptotal_in)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'penjualan_retur';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_in'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] + $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_in'] = $hpptotal_in;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] + $hpptotal_in;
            $insert['keterangan'] = "Retur Penjualan";

            $this->db->insert('stock', $insert);
        }
    }

    function stock_penjualan_retur_delete($waktu, $id_item, $qty, $hpp, $hpptotal_out)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'delete_penjualan_retur';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_out'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] - $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_out'] = $hpptotal_out;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] - $hpptotal_out;
            $insert['keterangan'] = "Delete Retur Penjualan";

            $this->db->insert('stock', $insert);
        }
    }
    


    function penyesuaian_stock_surplus($waktu, $id_item, $qty, $hpp, $hpptotal_in)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'penyesuaian_stock';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_in'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] + $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_in'] = $hpptotal_in;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] + $hpptotal_in;
            $insert['keterangan'] = "Penyesuaian Stock";

            $this->db->insert('stock', $insert);
        }
    }

    function penyesuaian_stock_minus($waktu, $id_item, $qty, $hpp, $hpptotal_out)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'penyesuaian_stock';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_out'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] - $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_out'] = $hpptotal_out;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] - $hpptotal_out;
            $insert['keterangan'] = "Penyesuaian Stock";

            $this->db->insert('stock', $insert);
        }
    }

    function stock_opname_surplus($waktu, $id_item, $qty, $hpp, $hpptotal_in)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'stock_opname';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_in'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] + $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_in'] = $hpptotal_in;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] + $hpptotal_in;
            $insert['keterangan'] = "Stock Opname";

            $this->db->insert('stock', $insert);
        }
    }

    function stock_opname_minus($waktu, $id_item, $qty, $hpp, $hpptotal_out)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'stock_opname';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_out'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] - $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_out'] = $hpptotal_out;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] - $hpptotal_out;
            $insert['keterangan'] = "Stock Opname";

            $this->db->insert('stock', $insert);
        }
    }


    function stock_barang_grosir_buka($waktu, $id_item, $qty, $hpp, $hpptotal_out)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'ecer';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_out'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] - $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_out'] = $hpptotal_out;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] - $hpptotal_out;
            $insert['keterangan'] = "Ecer";

            $this->db->insert('stock', $insert);
        }
    }

    function stock_barang_ecer_tambah($waktu, $id_item, $qty, $hpp, $hpptotal_in)
    {
        $this->db->where('id_item', $id_item);
        $db = $this->db->get('m_item');
        $hitung_stok = 1;
        if ($db->num_rows() > 0) {
            $hitung_stok = intval($db->row_array()['hitung_stock']);
        }

        if ($hitung_stok > 0) {
            $insert['table'] = 'ecer';
            $insert['waktu'] = $waktu;
            $insert['id_item'] = $id_item;
            $insert['qty_awal'] = $this->stock_akhir($id_item);
            $insert['qty_in'] = $qty;
            $insert['qty_akhir'] = $insert['qty_awal'] + $qty;
            $insert['hpp'] = $hpp;
            $insert['hpptotal_awal'] = $this->hpptotal_akhir($id_item);
            $insert['hpptotal_in'] = $hpptotal_in;
            $insert['hpptotal_akhir'] = $insert['hpptotal_awal'] + $hpptotal_in;
            $insert['keterangan'] = "Ecer";

            $this->db->insert('stock', $insert);
        }
    }
}
