<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'satuan',
        'kategori',
        'grade',
        'imei_1',
        'imei_2',
        'jumlah_stok',
        'modal',
        'harga_jual',
        'invoice',
        'supplier',
        'no_kontak_supplier',
        'tanggal',
        'keterangan',
        'garansi',
        'foto',
    ];
}
