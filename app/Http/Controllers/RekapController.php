<?php

namespace App\Http\Controllers;

use App\Models\JasaImei;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function rekapPenjualan(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date']);
        $penjualans = Penjualan::latest()->filter($filters)->get();
        $jasa_imeis = JasaImei::latest()->filter($filters)->get();
        return view('components.pages.penjualans.rekap', [
            'title' => 'Data Penjualan',
            'penjualans' => $penjualans,
        ]);
    }

    public function rekapPenjualanAgen(Request $request)
    {
        $filters = $request->only(['search', 'start_date', 'end_date', 'username']);
        $users = User::isAgent()->latest()->get();
        $displayPerUser = null;

        if ($request->filled('username')) {
            $user = $users->firstWhere('username', $request->username);
            $displayPerUser = optional($user)->name;
        } elseif ($request->filled('search')) {
            $displayPerUser = $request->search;
        }

        $penjualans = Penjualan::isAgent()->latest()->filter($filters)->get();
        return view('components.pages.penjualans.rekap', [
            'title' => 'Data Penjualan Agen',
            'penjualans' => $penjualans,
            'users' => $users,
            'displayPerUser' => $displayPerUser,
        ]);
    }
}
