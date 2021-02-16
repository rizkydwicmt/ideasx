<?php
defined('BASEPATH') or exit('No direct script access allowed');

    function tegar_num($number){
    if ($number < 0) {
            $number = '('.number_format(abs($number),0,',','.').')';
        } else {
            $number =  number_format($number,0,',','.');
        }
        return $number;    
    }
