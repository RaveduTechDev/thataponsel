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
        // 1. Parse IDs (atau export semua kalau kosong)

        if ($request->ids) {

            $ids = $request->ids
                ? explode(',', $request->ids)
                : Penjualan::pluck('id')->toArray();

            // 2. Ambil semua penjualan yang dipilih (beserta relasi)
            $penjualans = Penjualan::with(['pelanggan', 'stock.barang'])
                ->whereIn('id', $ids)
                ->get();

            // 3. Validasi: harus berasal dari pelanggan yang sama
            $pelangganIds = $penjualans->pluck('pelanggan_id')->unique();
            if ($pelangganIds->count() > 1) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'ids' => 'Pilih hanya transaksi dari satu pelanggan saja sebelum cetak.'
                    ]);
            }

            // 4. Group data untuk invoice
            $data = $penjualans
                ->sortBy('created_at') // atau orderBy di query
                ->groupBy('pelanggan_id'); // satu grup, karena cuma satu pelanggan

            // 5. Generate PDF atau Excel
            if ($request->export == 'pdf') {
                $pdf = Pdf::loadView('components.pages.penjualans.invoice-detail', compact('data'))->setPaper('a4', 'portrait')->setOption([
                    'defaultFont' => 'Poppins',
                ]);
                return $pdf->stream("invoice_{$pelangganIds->first()}.pdf");
            }
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
