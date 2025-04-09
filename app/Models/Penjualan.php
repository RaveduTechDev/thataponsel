<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{
    /** @use HasFactory<\Database\Factories\PenjualanFactory> */
    use HasFactory;

    protected $fillable = [
        'invoice',
        'pelanggan_id',
        'toko_cabang_id',
        'agent_id',
        'stock_id',
        'subtotal',
        'diskon',
        'total_bayar',
        'tanggal_transaksi',
        'status',
    ];

    protected $with = ['pelanggan', 'tokoCabang', 'agent', 'stock'];

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

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    // filter yang status selesai 
    public function scopeSuccess(Builder $query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? false, function (Builder $query, string $search) {
            return $query->whereHas('agent', function (Builder $query) use ($search) {
                $query->whereRaw('LOWER(nama_agen) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        });

        $query->when($filters['start_date'] ?? false, function (Builder $query, string $start_date) {
            return $query->whereDate('tanggal_transaksi', '>=', $start_date);
        });

        $query->when($filters['end_date'] ?? false, function (Builder $query, string $end_date) {
            return $query->whereDate('tanggal_transaksi', '<=', $end_date);
        });

        $query->when($filters['agent'] ?? false, function (Builder $query, string $username) {
            return $query->whereHas('agent', function (Builder $query) use ($username) {
                $query->where('username', $username);
            });
        });
    }
}
