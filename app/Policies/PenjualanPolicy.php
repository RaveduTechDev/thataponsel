<?php

namespace App\Policies;

class PenjualanPolicy
{
    /**
     * Create a new policy instance.
     */
    // public function __construct()
    // {
    //     //
    // }

    // jika penjualan sudah selesai, maka tidak bisa diupdate
    public function update($penjualan)
    {
        if ($penjualan->status === 'selesai') {
            return false;
        }
        return true;
    }
}
