<?php
defined('BASEPATH') or exit('No direct script access allowed');


function date_id($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    list($dd, $mm, $yyyy) = explode('-', $tanggal);

    return $dd . ' ' . $bulan[(int) $mm] . ' ' . $yyyy;
}
