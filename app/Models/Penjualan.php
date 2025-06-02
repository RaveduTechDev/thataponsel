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
        'user_id',
        'stock_id',
        'qty',
        'subtotal',
        'diskon',
        'total_bayar',
        'metode_pembayaran',
        'tanggal_transaksi',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'invoice';
    }

    protected $with = ['pelanggan', 'tokoCabang', 'stock', 'user'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class)->withTrashed()->select('id', 'nama_pelanggan', 'nomor_wa');
    }

    public function tokoCabang()
    {
        return $this->belongsTo(TokoCabang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed()->select('id', 'name', 'username');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function scopeSuccess(Builder $query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeIsAgent()
    {
        return $this->whereHas('user', function (Builder $query) {
            $query->whereHas('roles', function (Builder $query) {
                $query->where('name', 'agen');
            });
        });
    }

    public function scopeIsAgenAuth(Builder $query, $role, $username)
    {
        return $query->whereHas('user', function (Builder $query) use ($role, $username) {
            $query->where('username', $username)->whereHas('roles', function (Builder $query) use ($role) {
                $query->where('name', $role);
            });
        });
    }

    public function scopeFilter(Builder $query, array $filters)
    {

        $startDate = $filters['start_date'] ?? null;
        $endDate = $filters['end_date'] ?? null;

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('tanggal_transaksi', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('tanggal_transaksi', '<=', $endDate);
        }

        $query->when($filters['search'] ?? false, function (Builder $query, string $search) {
            return $query->whereHas('user', function (Builder $query) use ($search) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        });

        $query->when(isset($filters['username']), function (Builder $query) use ($filters) {
            $query->whereHas('user', function (Builder $query) use ($filters) {
                $query->where('username', 'like', '%' . $filters['username'] . '%');
            });
        });
    }
}
