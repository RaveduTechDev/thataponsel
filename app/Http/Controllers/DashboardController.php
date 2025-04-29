<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Stock;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $start = Carbon::now()->subMonths(5)->startOfMonth();
        $end = Carbon::now()->endOfMonth();

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
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agen');
            })->get();

        $dataAgen = $users->pluck('name')->map(fn($name) => ucfirst($name));
        $totalPenjualan = $users->pluck('jumlah_transaksi');

        // top 5 barang paling laku beserta nama barangnya yang diambil dari stock
        $top5 = DB::table('penjualans')
            ->join('stocks', 'stocks.id', '=', 'penjualans.stock_id') // Corrected table name
            ->join('barangs', 'barangs.id', '=', 'stocks.barang_id')
            ->select(
                'barangs.nama_barang',
                DB::raw('COUNT(*) as total_terjual')   // hitung baris
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


        return view('welcome', [
            'months' => $months,
            'data' => $data,
            'dataAgen' => $dataAgen,
            'totalPenjualan' => $totalPenjualan,
            'barangLabel' => $barangLabel,
            'jumlahBarang' => $jumlahBarang,
        ]);
    }
}
