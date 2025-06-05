<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JasaImei extends Model
{
    /** @use HasFactory<\Database\Factories\JasaImeiFactory> */
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'tipe',
        'imei',
        'biaya',
        'modal',
        'profit',
        'metode_pembayaran',
        'status',
        'supplier',
        'user_id',
        'tanggal',
    ];

    protected $with = ['pelanggan', 'user'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class)->select('id', 'nama_pelanggan', 'nomor_wa');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'username', 'nomor_wa', 'toko_cabang_id');
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeIsAgent($query, $role)
    {
        if ($role == 'agen') {
            return $query->where('user_id', Auth::user()->id);
        }
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
