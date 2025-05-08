<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Stock;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\NumberCustom;
use App\Models\JasaImei;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $start = null;
        $end = null;

        if ($request->has('start_date') || $request->has('end_date')) {
            $start = Carbon::parse($request->input('start_date'));
            $end = Carbon::parse($request->input('end_date'));
        } else {
            $start = Carbon::now()->subMonths(5)->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        }

        // $start = Carbon::now()->subMonths(5)->startOfMonth();
        // $end = Carbon::now()->endOfMonth();

        $penjualan = Penjualan::whereBetween('tanggal_transaksi', [$start, $end])
            ->orderBy('tanggal_transaksi')
            ->get();

        $grouped = $penjualan->groupBy(fn($item) => Carbon::parse($item->tanggal_transaksi)->isoFormat('MMMM Y'));

        $months = collect();
        $data = collect();
        $current = $start->copy();
        while ($current <= $end) {
            $label = $current->isoFormat('MMMM Y');
            $months->push($label);
            $data->push($grouped->has($label) ? $grouped->get($label)->count() : 0);
            $current->addMonth();
        }

        // performance agen/penjualan
        $users = User::select('name', 'jumlah_transaksi')
            ->orderBy('jumlah_transaksi', 'asc')
            ->take(7)
            ->whereHas('penjualans', function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_transaksi', [$start, $end]);
            })
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agen');
            })->get();

        $dataAgen = $users->pluck('name')->map(fn($name) => ucfirst($name));
        $totalPenjualan = $users->pluck('jumlah_transaksi');

        // top 5 barang paling laku beserta nama barangnya yang diambil dari stock
        $top5 = DB::table('penjualans')
            ->join('stocks', 'stocks.id', '=', 'penjualans.stock_id')
            ->join('barangs', 'barangs.id', '=', 'stocks.barang_id')
            ->whereBetween('penjualans.tanggal_transaksi', [$start, $end])
            ->select(
                'barangs.nama_barang',
                DB::raw('COUNT(*) as total_terjual')
            )
            ->groupBy('stocks.id', 'barangs.nama_barang')
            ->limit(5)
            ->get();

        $barangLabel = $top5->pluck('nama_barang');
        $colors = ['#8B0000', '#B22222', '#DC143C', '#FF6347', '#FF7F7F'];
        $jumlahBarang = $top5->map(function ($item, $idx) use ($colors) {
            return [
                'value'     => $item->total_terjual,
                'itemStyle' => ['color' => $colors[$idx] ?? '#' . dechex(rand(0xFF0000, 0xFF9999))]
            ];
        });

        // cashflow penjualan modal dari tabel stock, harga jual dari tabel penjualan yang akan digunakan ke pie chart
        $totalHargaModal = DB::table('penjualans')
            ->join('stocks', 'penjualans.stock_id', '=', 'stocks.id')
            ->whereBetween('penjualans.tanggal_transaksi', [$start, $end])
            ->sum('stocks.modal');
        $totalHargaPenjualan = DB::table('penjualans')
            ->whereBetween('tanggal_transaksi', [$start, $end])
            ->sum(DB::raw('CAST(total_bayar AS NUMERIC)'));

        // unit masuk dari stock => jumlah_stok dan unit keluar => jumlah terjual dari stock_id dengan status selesai
        $totalUnitMasuk = Stock::whereHas('penjualan', function ($query) use ($start, $end) {
            $query->whereBetween('tanggal_transaksi', [$start, $end]);
        })->sum('jumlah_stok');
        $totalUnitKeluar = Penjualan::where('status', 'selesai')
            ->whereBetween('tanggal_transaksi', [$start, $end])
            ->count('penjualans.status');

        // total yang selesai dari imeis
        $totalLayananImei = JasaImei::where('status', 'selesai')
            ->count('jasa_imeis.status');

        // unit terjual dari penjualan
        $totalUnitTerjual = Penjualan::where('status', 'selesai')
            ->whereBetween('tanggal_transaksi', [$start, $end])
            ->count('penjualans.status');

        // total harga keseluruhan penjualan dan imei 
        $totalHargaPenjualan = DB::table('penjualans')
            ->where('status', 'selesai')
            ->whereBetween('tanggal_transaksi', [$start, $end])
            ->sum(DB::raw('CAST(total_bayar AS NUMERIC)'));

        $totalBiayaImei = DB::table('jasa_imeis')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$start, $end])
            ->sum(DB::raw('CAST(biaya AS NUMERIC)'));

        $totalPenjualanDanImei = $totalHargaPenjualan + $totalBiayaImei;
        $formatHumanNumber = 'Rp.' . NumberCustom::formatNumber($totalPenjualanDanImei);

        // keuntungan penjualan dan imei
        $totalKeuntunganPenjualan = $totalHargaPenjualan - $totalHargaModal;

        $modalImei = DB::table('jasa_imeis')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$start, $end])
            ->sum(DB::raw('CAST(modal AS NUMERIC)'));
        $totalKeuntunganImei = $totalBiayaImei - $modalImei;

        $totalKeuntungan = $totalKeuntunganPenjualan + $totalKeuntunganImei;
        $formatKeuntungan = NumberCustom::formatNumber($totalKeuntungan);

        // penjualan imei untuk per 6 bulan
        $penjualanImeiPerBulan = JasaImei::where('status', 'selesai')
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->created_at)->isoFormat('MMMM Y'));

        $imeiMonths = collect();
        $imeiData = collect();
        $currentImei = $start->copy();
        while ($currentImei <= $end) {
            $label = $currentImei->isoFormat('MMMM Y');
            $imeiMonths->push($label);
            $imeiData->push($penjualanImeiPerBulan->has($label) ? $penjualanImeiPerBulan->get($label)->count() : 0);
            $currentImei->addMonth();
        }

        return view('welcome', [
            'months' => $months,
            'data' => $data,
            'dataAgen' => $dataAgen,
            'totalPenjualan' => $totalPenjualan,
            'barangLabel' => $barangLabel,
            'jumlahBarang' => $jumlahBarang,
            'totalHargaModal' => $totalHargaModal,
            'totalHargaPenjualan' => $totalHargaPenjualan,
            'totalUnitMasuk' => $totalUnitMasuk,
            'totalUnitKeluar' => $totalUnitKeluar,
            'totalUnitTerjual' => $totalUnitTerjual,
            'totalLayananImei' => $totalLayananImei,
            'totalBiayaImei' => $totalBiayaImei,
            'formatHumanNumber' => $formatHumanNumber,
            'formatKeuntungan' => $formatKeuntungan,
            'modalImei' => $modalImei,
            'imeiMonths' => $imeiMonths,
            'imeiData' => $imeiData,
        ]);
    }
}
