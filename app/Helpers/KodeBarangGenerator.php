<?php

namespace App\Helpers;

use App\Models\Barang;

class KodeBarangGenerator
{
    public static function generateKode($prefix = 'TP', $length = 4)
    {
        $date = now()->format('ymd');
        $lastBarang = Barang::where('kode_barang', 'like', '%' . $date . '%')->latest()->first();
        $lastKode = $lastBarang ? (int) substr($lastBarang->kode_barang, -$length) : 0;
        $newKode = $prefix . '-' . $date . '-' . str_pad($lastKode + 1, $length, '0', STR_PAD_LEFT);
        return $newKode;
    }
}
