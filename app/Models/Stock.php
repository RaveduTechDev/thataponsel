<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Stock extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory, InteractsWithMedia;

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
    ];

    public function getRouteKeyName(): string
    {
        return 'kode_barang';
    }
}
