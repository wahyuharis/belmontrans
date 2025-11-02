<?php

class Setting_model extends CI_Model
{

    function get_all()
    {
        $db = $this->db->get('_setting');
        $buff = array();
        foreach ($db->result_array() as $row) {
            $buff[$row['variable']] = $row['value'];
        }

        return $buff;
    }

    function get($variable)
    {
        $this->db->where('variable', $variable);
        $db = $this->db->get('_setting');
        return $db->row_array()['value'];
    }
}
