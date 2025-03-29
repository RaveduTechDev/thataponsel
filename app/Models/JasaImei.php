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
        'agent_id'
    ];

    protected $with = ['pelanggan', 'agent'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
