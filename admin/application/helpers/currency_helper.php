<?php

function intval2($rupiah)
{
    $rupiah = trim($rupiah);
    $number = str_replace('.', '', $rupiah);
    $number = str_replace(',', '.', $number);
    return intval($number);
}

// function is_float2($float)
// {
//     $float = floatval($float) . "";
//     $pos = strpos($float, '.');
//     if ($pos > 0) {
//         return true;
//     } else {
//         return false;
//     }
// }

function floatval2($rupiah)
{

    $rupiah = trim($rupiah);
    $number = str_replace('.', '', $rupiah);
    $number = str_replace(',', '.', $number);
    return floatval($number);
}

function format_currency($angka)
{
    $return = '';

    $return = number_format($angka, 0, ',', '.');

    return $return;
}
