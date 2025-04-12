<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokoCabang extends Model
{
    /** @use HasFactory<\Database\Factories\TokoCabangFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_toko_cabang',
        'penanggung_jawab_toko',
        'alamat_toko'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
