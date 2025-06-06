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
        'barang_id',
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

    protected $with = ['barang'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    // format phone number to INTERNATIONAL
    public function getNoKontakSupplierAttribute()
    {
        try {
            return phone($this->attributes['no_kontak_supplier'], 'ZZ', \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
        } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
            return $this->attributes['no_kontak_supplier'];
        }
    }
}
