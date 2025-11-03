<?php
function get_kontak($nama_kontak, $param)
{
    $ci = &get_instance();
    $ci->db->where('nama_kontak', $nama_kontak);
    $db = $ci->db->get('kontak');

    return $result = $db->row_array()[$param];
}
function get_baner($nama_baner, $param)
{
    $ci = &get_instance();
    $ci->db->where('nama_baner', $nama_baner);
    $db = $ci->db->get('baner');

    return $result = $db->row_array()[$param];
}
