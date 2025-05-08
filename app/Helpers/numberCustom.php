<?php

namespace App\Helpers;

class NumberCustom
{
    public static function formatNumber($number)
    {
        $units = [
            1 => '',
            1e3 => 'Ribu',
            1e6 => 'Juta',
            1e9 => 'Milyar',
            1e12 => 'Triliun',
            1e15 => 'Kuadriliun',
            1e18 => 'Kuintiliun',
            1e21 => 'Sekstiliun',
            1e24 => 'Septiliun',
            1e27 => 'Oktiliun',
        ];

        foreach ($units as $value => $suffix) {
            if ($number < $value * 1000) {
                return round($number / $value, 1) . ' ' . $suffix;
            }
        }

        return $number;
    }
}
