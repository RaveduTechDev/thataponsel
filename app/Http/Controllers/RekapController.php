<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function rekapPenjualan(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date']);
        $penjualans = Penjualan::latest()->filter($filters)->get();
        return view('components.pages.penjualans.rekap', [
            'title' => 'Data Penjualan',
            'penjualans' => $penjualans,
        ]);
    }

    public function rekapPenjualanAgen(Request $request)
    {
        $filters = $request->only(['search', 'start_date', 'end_date', 'username']);
        $agents = Agent::latest()->get();
        $penjualans = Penjualan::latest()->filter($filters)->get();
        return view('components.pages.penjualans.rekap', [
            'title' => 'Data Penjualan Agen',
            'penjualans' => $penjualans,
            'agents' => $agents,
        ]);
    }
}
