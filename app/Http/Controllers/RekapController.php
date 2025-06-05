<?php

namespace App\Http\Controllers;

use App\Exports\RekapExport;
use App\Exports\RekapImeiExport;
use App\Exports\RekapPenjualanExport;
use App\Models\JasaImei;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class RekapController extends Controller
{
    public function rekapPenjualan(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date']);
        $penjualans = Penjualan::latest()->filter($filters)->success()->get();
        $jasa_imeis = JasaImei::latest()->filter($filters)->success()->get();
        return view('components.pages.penjualans.rekap', [
            'penjualans' => $penjualans,
            'jasa_imeis' => $jasa_imeis,
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

        $penjualans = Penjualan::isAgent()->success()->latest()->filter($filters)->get();
        $jasa_imeis = JasaImei::isAgentImei()->success()->latest()->filter($filters)->get();
        return view('components.pages.penjualans.rekap', [
            'penjualans' => $penjualans,
            'users' => $users,
            'displayPerUser' => $displayPerUser,
            'jasa_imeis' => $jasa_imeis,
        ]);
    }

    // rekap export excel
    public function rekapExportImeiExcel(Request $request)
    {
        $filters = $request->only(['search', 'start_date', 'end_date', 'username']);

        try {
            return Excel::download(new RekapImeiExport($filters), 'rekap_jasa_imei.xlsx');
        } catch (\Exception $e) {
            Log::error('Error exporting jasa imei: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to export jasa imei.']);
        }
    }

    public function rekapExportPenjualanExcel(Request $request)
    {
        $filters = $request->only(['search', 'start_date', 'end_date', 'username']);

        try {
            return Excel::download(new RekapPenjualanExport($filters), 'rekap_penjualan.xlsx');
        } catch (\Exception $e) {
            Log::error('Error exporting penjualan: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to export penjualan.']);
        }
    }
}
