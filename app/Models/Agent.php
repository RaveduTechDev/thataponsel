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

    protected $with = ['tokoCabang'];

    public function tokoCabang()
    {
        return $this->belongsTo(TokoCabang::class)->select('id', 'nama_toko_cabang');
    }
}
