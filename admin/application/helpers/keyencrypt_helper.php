<?php

function encrypt_key($plain_text)
{
    $ci = &get_instance();
    $ci->load->library('encryption');

    $ci->encryption->initialize(
        array(
            'driver' => 'openssl',
            'cipher' => 'aes-128',
            'mode' => 'ctr',
        )
    );

    $ciphertext = $ci->encryption->encrypt($plain_text);
    $ciphertext_uri_encoded=urlencode($ciphertext);

    return $ciphertext_uri_encoded;
}

function decrypt_key($ciphertext_uri_encoded)
{
    $ci = &get_instance();
    $ci->load->library('encryption');

    $ci->encryption->initialize(
        array(
            'driver' => 'openssl',
            'cipher' => 'aes-128',
            'mode' => 'ctr',
        )
    );

    $ciphertext=urldecode($ciphertext_uri_encoded);

    $plain_text = $ci->encryption->decrypt($ciphertext);

    return $plain_text;
}


function encode_key($plain){
    $encoded='';
    $encoded=urlencode(base64_encode($plain));
    return $encoded;
}

function decode_key($encoded){
    $plain='';
    $plain=base64_decode(urldecode($encoded));
    return $plain;
}
