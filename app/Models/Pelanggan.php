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
        $number = preg_replace('/\s+/', '', $this->nomor_wa);

        if (preg_match('/^0/', $number)) {
            $number = preg_replace('/^0/', '+62', $number);
        } elseif (!preg_match('/^\+62/', $number)) {
            $number = '+62' . $number;
        }

        return phone($number, 'ID')->formatInternational();
    }
}
