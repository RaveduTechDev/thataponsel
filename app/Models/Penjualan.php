<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    /** @use HasFactory<\Database\Factories\PenjualanFactory> */
    use HasFactory;

    protected $fillable = [
        'invoice',
        'pelanggan_id',
        'toko_cabang_id',
        'agent_id',
        'barang_id',
        'subtotal',
        'diskon',
        'total_bayar',
        'tanggal_transaksi',
        'status',
    ];

    protected $with = ['pelanggan', 'tokoCabang', 'agent'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function tokoCabang()
    {
        return $this->belongsTo(TokoCabang::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function barang()
    {
        return $this->belongsTo(Stock::class);
    }
}
