<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Exports\PenjualanExport;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        if ($request->ids) {
            $ids = $request->ids
                ? explode(',', $request->ids)
                : Penjualan::pluck('id')->toArray();

            $penjualans = Penjualan::with(['pelanggan', 'stock.barang'])
                ->whereIn('id', $ids)
                ->get();

            $pelangganIds = $penjualans->pluck('pelanggan_id')->unique();
            if ($pelangganIds->count() > 1) {
                return redirect()->back()->withInput()
                    ->withErrors([
                        'ids' => 'Pilih hanya transaksi dari satu pelanggan saja sebelum cetak.'
                    ]);
            }

            $pelangganStatus = $penjualans->where('pelanggan_id', $pelangganIds->first())->first()->status;
            if ($pelangganStatus != 'selesai') {
                return redirect()->back()->withInput()
                    ->withErrors([
                        'ids' => 'Terdapat transaksi yang belum selesai, tidak bisa dicetak.'
                    ]);
            }

            $data = $penjualans->sortBy('created_at')->groupBy('pelanggan_id');

            if ($request->export == 'pdf') {
                $pdf = Pdf::loadView('components.pages.penjualans.invoice-detail', compact('data'))->setPaper('a4', 'portrait')->setOption([
                    'defaultFont' => 'Poppins',
                ]);
                return $pdf->stream("invoice_{$pelangganIds->first()}.pdf");
            }
        } else  if ($request->export == 'excel') {
            return Excel::download(new PenjualanExport(), 'penjualan.xlsx');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'ids' => 'Pilih transaksi yang ingin dicetak.'
                ]);
        }
    }
}
