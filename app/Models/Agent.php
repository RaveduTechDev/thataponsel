<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    /** @use HasFactory<\Database\Factories\AgentFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_agen',
        'nomor_wa',
        'toko_cabang_id',
        'jumlah_transaksi',
    ];

    public function getNomorWaAgentFormattedAttribute(): string
    {
        $number = preg_replace('/\s+/', '', $this->nomor_wa);

        if (preg_match('/^0/', $number)) {
            $number = preg_replace('/^0/', '+62', $number);
        } elseif (!preg_match('/^\+62/', $number)) {
            $number = '+62' . $number;
        }

        try {
            return phone($number, 'ID')->formatInternational();
        } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
            return $this->nomor_wa;
        }
    }

    protected $with = ['tokoCabang'];

    public function tokoCabang()
    {
        return $this->belongsTo(TokoCabang::class)->select('id', 'nama_toko_cabang');
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
