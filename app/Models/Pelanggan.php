<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'nomor_wa',
        'jumlah_transaksi',
    ];

    public function getNomorWaFormattedAttribute(): string
    {
        try {
            return phone($this->attributes['nomor_wa'], 'ZZ', \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
        } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
            return $this->attributes['nomor_wa'];
        }
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function jasaImeis()
    {
        return $this->hasMany(JasaImei::class);
    }
}
