<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Exports\PenjualanExport;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ExportController extends Controller
{
    public function export(?Penjualan $penjualan = null, Request $request)
    {
        $exportType = $request->input('export');
        $ids = $request->filled('ids') ? explode(',', $request->ids) : [];

        try {
            if ($exportType === 'excel') {
                if ($request->filled('ids')) {
                    $ids = explode(',', $request->ids);
                    $penjualans = Penjualan::whereIn('id', $ids)->get();

                    if ($penjualans->isEmpty()) {
                        return back()->withErrors(['export' => 'Data tidak ditemukan untuk ID yang dipilih.']);
                    }

                    $fileName = "penjualan_thataponsel_terpilih_" . now()->format('dmY') . ".xlsx";
                    return Excel::download(new PenjualanExport($penjualans), $fileName);
                }

                $fileName = auth()->user()->hasRole('agen')
                    ? "penjualan_thataponsel_" . auth()->user()->username . "_" . now()->format('dmY') . ".xlsx"
                    : "penjualan_thataponsel_" . now()->format('dmY') . ".xlsx";

                return Excel::download(new PenjualanExport(), $fileName);
            }

            if (empty($ids)) {
                return back()->withInput()->withErrors([
                    'ids' => 'Pilih transaksi yang ingin dicetak.'
                ]);
            }

            $penjualans = Penjualan::with(['pelanggan', 'stock.barang', 'user'])
                ->whereIn('id', $ids)
                ->get();

            if ($penjualans->isEmpty()) {
                return back()->withErrors(['ids' => 'Data penjualan tidak ditemukan.']);
            }

            $uniquePelangganIds = $penjualans->pluck('pelanggan_id')->unique();
            $uniqueUserIds = $penjualans->pluck('user_id')->unique();

            if ($uniquePelangganIds->count() > 1 && $uniqueUserIds->count() > 1) {
                return back()->withInput()->withErrors([
                    'ids' => 'Pilih hanya transaksi dari satu pelanggan dan satu agen saja sebelum cetak.'
                ]);
            }

            if ($uniquePelangganIds->count() > 1) {
                return back()->withInput()->withErrors([
                    'ids' => 'Pilih hanya transaksi dari satu pelanggan saja sebelum cetak.'
                ]);
            }

            if ($uniqueUserIds->count() > 1) {
                return back()->withInput()->withErrors([
                    'ids' => 'Pilih hanya transaksi dari satu agen saja sebelum cetak.'
                ]);
            }

            $isAllSelesai = $penjualans->every(fn($item) => $item->status === 'selesai');
            if (! $isAllSelesai) {
                return back()->withInput()->withErrors([
                    'ids' => 'Terdapat transaksi yang belum selesai, tidak bisa dicetak.'
                ]);
            }

            $data = $penjualans->sortBy('created_at')->groupBy('pelanggan_id');

            if ($exportType === 'pdf') {
                $pdf = Pdf::loadView('components.pages.penjualans.invoice-detail', compact('data'))
                    ->setPaper('a4', 'portrait')
                    ->setOption(['defaultFont' => 'Poppins']);

                return $pdf->stream("invoice_{$uniquePelangganIds->first()}.pdf");
            }

            return back()->withErrors(['export' => 'Jenis export tidak valid.']);
        } catch (\Exception $e) {
            Log::error('Export Error: ' . $e->getMessage());

            return back()->withErrors([
                'export' => 'Terjadi kesalahan saat export. Silakan coba lagi.'
            ]);
        }
    }
}
