<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Barang extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\BarangFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'merk',
        'tipe',
        'memori',
        'warna',
        'satuan',
        'kategori',
        'grade',
        'keterangan',
    ];

    public function getRouteKeyName(): string
    {
        return 'kode_barang';
    }
}
