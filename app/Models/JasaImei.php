<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'status',
        'supplier',
        'user_id'
    ];

    protected $with = ['pelanggan', 'user'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }
}
