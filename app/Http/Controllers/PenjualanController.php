<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Stock;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\TokoCabang;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PenjualanRequest;
use App\Models\User;

class PenjualanController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('role:super_admin|owner|admin|agen')->only('index');
        $this->middleware('role:super_admin|admin|agen')->only(['create', 'store']);
        $this->middleware('role:super_admin|admin')->only(['edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = [];
        $role = Auth::user()->getRoleNames()->first();

        if ($role == 'agen') {
            $penjualans = Penjualan::isAgenAuth($role, Auth::user()->username)->latest()->get();
        } else {
            $penjualans = Penjualan::latest()->get();
        }

        return view('components.pages.penjualans.index', [
            'title' => $role == 'agen' ? 'History Penjualan Anda' : 'Transaksi Penjualan',
            'penjualans' => $penjualans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $date = now()->format('dmy');
        $lastPenjualan = Penjualan::where('invoice', 'like', '%' . $date . '%')->latest()->first();
        $lastInvoice = $lastPenjualan ? (int) substr($lastPenjualan->invoice, -4) : 0;
        $newInvoice = 'INV-' . $date . '-' . str_pad($lastInvoice + 1, 4, '0', STR_PAD_LEFT);

        $stocks = Stock::latest()->get();
        $pelanggans = Pelanggan::latest()->get();
        $toko_cabangs = TokoCabang::latest()->get();
        $users = User::latest()->get();
        return view('components.pages.penjualans.create', [
            'title' => 'Tambah Penjualan',
            'stocks' => $stocks,
            'pelanggans' => $pelanggans,
            'toko_cabangs' => $toko_cabangs,
            'users' => $users,
            'newInvoice' => $newInvoice,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenjualanRequest $request)
    {
        $data = $request->validated();
        try {
            $stock = Stock::findOrFail($data['stock_id']);
            if ($stock->jumlah_stok <= 0) {
                return redirect()->back()->with('error', 'Stok dari ' . $stock->barang->nama_barang . ' habis');
            }

            $user = null;
            $pelanggan = null;

            if (empty($data['user_id']) && Auth::user()->hasRole('agen')) {
                $data['user_id'] = Auth::user()->id;
            }

            if ($data['status'] == 'selesai') {
                if (empty($data['user_id']) && Auth::user()->hasRole('agen')) {
                    $data['user_id'] = Auth::user()->id;
                    $user = User::findOrFail(Auth::user()->id);
                    $user->increment('jumlah_transaksi');
                } else {
                    $user = User::findOrFail($data['user_id']);
                    $user->increment('jumlah_transaksi');
                }

                if (empty($data['pelanggan_id'])) {
                    return redirect()->back()->with('error', 'Pilih pelanggan untuk menyelesaikan transaksi');
                }
                $pelanggan = Pelanggan::findOrFail($data['pelanggan_id']);
                $pelanggan->increment('jumlah_transaksi');
            }

            if ($stock->jumlah_stok < $data['qty']) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk transaksi ini');
            }

            $jumlahStok = $stock->jumlah_stok - $data['qty'];
            $stock->jumlah_stok = $jumlahStok;
            $stock->save();

            $penjualan = Penjualan::create($data);

            if ($penjualan) {
                return redirect()->route('penjualan.index')->with('success', 'Data Penjualan berhasil ditambahkan');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Penjualan gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        return view('components.pages.penjualans.show', [
            'title' => 'Detail Penjualan',
            'penjualan' => $penjualan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $stocks = Stock::latest()->get();
        $pelanggans = Pelanggan::latest()->get();
        $toko_cabangs = TokoCabang::latest()->get();
        $users = User::latest()->get();
        return view('components.pages.penjualans.edit', [
            'title' => 'Edit Penjualan',
            'penjualan' => $penjualan,
            'stocks' => $stocks,
            'pelanggans' => $pelanggans,
            'toko_cabangs' => $toko_cabangs,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenjualanRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $penjualan = Penjualan::findOrFail($id);
            $oldStockId = $penjualan->stock_id;
            $newStockId = $data['stock_id'];
            $oldStatus = $penjualan->status;
            $newStatus = $data['status'];
            $user = null;
            $pelanggan = null;

            if ($newStatus === 'selesai' && $oldStatus === 'proses') {
                $user = User::findOrFail($data['user_id']);
                $user->increment('jumlah_transaksi');

                if (empty($data['pelanggan_id'])) {
                    return redirect()->back()->with('error', 'Pilih pelanggan untuk menyelesaikan transaksi');
                }
                $pelanggan = Pelanggan::findOrFail($data['pelanggan_id']);
                $pelanggan->increment('jumlah_transaksi');
            }


            if ($oldStockId != $newStockId) {
                $oldStock = Stock::findOrFail($oldStockId);
                $oldStock->jumlah_stok = $oldStock->jumlah_stok + $penjualan->qty;
                $oldStock->save();

                $newStock = Stock::findOrFail($newStockId);
                if ($newStock->jumlah_stok < $penjualan->qty) {
                    return redirect()->back()->with('error', 'Stok dari ' . $newStock->barang->nama_barang . ' tidak cukup');
                }
                $newStock->jumlah_stok = $newStock->jumlah_stok - $penjualan->qty;
                $newStock->save();
            }

            $penjualan->update($data);

            return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $penjualan = Penjualan::findOrFail($id);

            if ($penjualan->status !== 'selesai') {
                $stock = Stock::findOrFail($penjualan->stock_id);
                $stock->jumlah_stok = $stock->jumlah_stok + $penjualan->qty;
                $stock->save();
            }

            if ($penjualan->pelanggan_id) {
                $pelanggan = Pelanggan::findOrFail($penjualan->pelanggan_id);
                $pelanggan->decrement('jumlah_transaksi');
            }

            if ($penjualan->user_id) {
                $user = User::findOrFail($penjualan->user_id);
                $user->decrement('jumlah_transaksi');
            }

            $penjualan->delete();
            return redirect('/penjualan')->with('success', 'Data Penjualan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/penjualan')->withErrors('error', 'Penjualan gagal dihapus');
        }
    }
}
