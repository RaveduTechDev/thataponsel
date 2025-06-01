<?php

namespace App\Helpers;

class NumberCustom
{
    public static function formatNumber($number)
    {
        $units = [
            '1' => '',
            '1000' => 'Ribu',
            '1000000' => 'Juta',
            '1000000000' => 'Milyar',
            '1000000000000' => 'Triliun',
            '1000000000000000' => 'Kuadriliun',
            '1000000000000000000' => 'Kuintiliun',
            '1000000000000000000000' => 'Sekstiliun',
            '1000000000000000000000000' => 'Septiliun',
            '1000000000000000000000000000' => 'Oktiliun',
        ];

        foreach ($units as $value => $suffix) {
            if ($number < intval($value) * 1000) {
                return round($number / intval($value), 1) . ' ' . $suffix;
            }
        }

        return $number;
    }
}
