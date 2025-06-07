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
use Illuminate\Container\Attributes\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $notAgent = auth()->user()->hasRole(['super_admin', 'admin', 'owner']);

        $start = $request->has('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subMonths(5)->startOfMonth();
        $end = $request->has('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfMonth();

        $penjualanQuery = Penjualan::where('status', 'selesai')
            ->whereBetween('tanggal_transaksi', [$start, $end]);

        if (!$notAgent) {
            $penjualanQuery->whereHas('user.roles', function ($query) {
                $query->where('name', 'agen');
            })->where('user_id', auth()->id());
        }

        $penjualan = $penjualanQuery->get();

        $grouped = $penjualan->groupBy(fn($item) => Carbon::parse($item->tanggal_transaksi)->isoFormat('MMMM Y'));

        $months = collect();
        $data = collect();
        $current = $start->copy();
        while ($current <= $end) {
            $label = $current->isoFormat('MMMM Y');
            $months->push($label);
            $data->push($grouped->has($label) ? $grouped->get($label)->sum('qty') : 0);
            $current->addMonth();
        }

        if ($notAgent) {
            $users = User::select('name', 'jumlah_transaksi')
                ->orderBy('jumlah_transaksi', 'asc')
                ->take(7)
                ->whereHas('penjualans', function ($query) use ($start, $end) {
                    $query->whereBetween('tanggal_transaksi', [$start, $end]);
                })
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'agen');
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('penjualans')
                        ->whereRaw('users.id = penjualans.user_id')
                        ->where('penjualans.status', 'selesai');
                })->get();

            $dataAgen = $users->pluck('name')->map(fn($name) => ucfirst($name));
            $totalPenjualan = $users->pluck('jumlah_transaksi');

            $top5 = DB::table('penjualans')
                ->join('stocks', 'stocks.id', '=', 'penjualans.stock_id')
                ->join('barangs', 'barangs.id', '=', 'stocks.barang_id')
                ->whereBetween('penjualans.tanggal_transaksi', [$start, $end])
                ->where('penjualans.status', 'selesai')
                ->select(
                    'barangs.nama_barang',
                    DB::raw('SUM(penjualans.qty) as total_terjual'),
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
        }

        $totalHargaModal = DB::table('penjualans')
            ->join('stocks', 'penjualans.stock_id', '=', 'stocks.id')
            ->where('penjualans.status', 'selesai')
            ->whereBetween('penjualans.tanggal_transaksi', [$start, $end])
            ->sum(DB::raw('COALESCE(stocks.modal,0) * penjualans.qty')) ?? 0;

        $totalPenjualan = DB::table('penjualans')
            ->where('penjualans.status', 'selesai')
            ->whereBetween('penjualans.tanggal_transaksi', [$start, $end])
            ->sum(DB::raw('CAST(total_bayar AS DECIMAL)')) ?? 0;

        $totalUnitMasuk = Stock::whereHas('penjualan', function ($query) use ($start, $end) {
            $query->whereBetween('penjualans.tanggal_transaksi', [$start, $end]);
        })->sum('jumlah_stok') ?? 0;

        $totalUnitKeluar = Penjualan::where('status', 'selesai')
            ->whereBetween('tanggal_transaksi', [$start, $end])
            ->sum('qty') ?? 0;

        $totalLayananImei = JasaImei::where('status', 'selesai')
            ->whereBetween('created_at', [$start, $end])
            ->when(!$notAgent, function ($query) {
                $query->where('user_id', auth()->id());
            })->count('jasa_imeis.status') ?? 0;

        $totalUnitTerjual = Penjualan::where('status', 'selesai')
            ->whereBetween('tanggal_transaksi', [$start, $end])
            ->when(!$notAgent, function ($query) {
                $query->where('user_id', auth()->id());
            })->sum('qty') ?? 0;

        $totalHargaPenjualan = DB::table('penjualans')
            ->where('status', 'selesai')
            ->whereBetween('tanggal_transaksi', [$start, $end])
            ->sum(DB::raw('CAST(total_bayar AS DECIMAL)')) ?? 0;

        $totalBiayaImei = DB::table('jasa_imeis')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$start, $end])
            ->sum(DB::raw('CAST(biaya AS DECIMAL)')) ?? 0;

        $totalPenjualanDanImei = $totalHargaPenjualan + $totalBiayaImei;
        $formatHumanNumber = 'Rp' . NumberCustom::formatNumber($totalPenjualanDanImei);

        $totalKeuntunganPenjualan = $totalHargaPenjualan - $totalHargaModal;

        $modalImei = DB::table('jasa_imeis')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$start, $end])
            ->sum(DB::raw('CAST(modal AS DECIMAL)')) ?? 0;

        $totalKeuntunganImei = $totalBiayaImei - $modalImei;

        $totalKeuntungan = $totalKeuntunganPenjualan + $totalKeuntunganImei;
        $formatKeuntungan = 'Rp' . NumberCustom::formatNumber($totalKeuntungan);

        $penjualanImeiPerBulan = JasaImei::where('status', 'selesai')
            ->whereBetween('created_at', [$start, $end])
            ->when(!$notAgent, function ($query) {
                $query->where('user_id', auth()->id());
            })
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
            'dataAgen' => $notAgent ? $dataAgen : null,
            'totalPenjualan' => $notAgent ? $totalPenjualan : null,
            'barangLabel' => $notAgent ? $barangLabel : null,
            'jumlahBarang' => $notAgent ? $jumlahBarang : null,
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
