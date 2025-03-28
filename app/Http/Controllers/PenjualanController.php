<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenjualanRequest;
use App\Models\Agent;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Stock;
use App\Models\TokoCabang;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = Penjualan::latest()->get();
        return view('components.pages.penjualans.index', [
            'title' => 'Data Penjualan',
            'penjualans' => $penjualans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stocks = Stock::latest()->get();
        $pelanggans = Pelanggan::latest()->get();
        $toko_cabangs = TokoCabang::latest()->get();
        $agents = Agent::latest()->get();
        return view('components.pages.penjualans.create', [
            'title' => 'Tambah Penjualan',
            'stocks' => $stocks,
            'pelanggans' => $pelanggans,
            'toko_cabangs' => $toko_cabangs,
            'agents' => $agents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenjualanRequest $request)
    {
        $data = $request->validated();
        $data['tanggal_transaksi'] = date('Y-m-d');
        try {
            $stock = Stock::findOrFail($data['stock_id']);
            if ($stock->jumlah_stok <= 0) {
                return redirect()->back()->with('error', 'Stok dari ' . $stock->barang->nama_barang . ' habis');
            }

            $stock->decrement('jumlah_stok');
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
        $agents = Agent::latest()->get();
        return view('components.pages.penjualans.edit', [
            'title' => 'Edit Penjualan',
            'penjualan' => $penjualan,
            'stocks' => $stocks,
            'pelanggans' => $pelanggans,
            'toko_cabangs' => $toko_cabangs,
            'agents' => $agents,
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

            if ($oldStockId != $newStockId) {
                $oldStock = Stock::findOrFail($oldStockId);
                $oldStock->increment('jumlah_stok');

                $newStock = Stock::findOrFail($newStockId);
                if ($newStock->jumlah_stok <= 0) {
                    return redirect()->back()->with('error', 'Stok dari ' . $newStock->barang->nama_barang . ' habis');
                }
                $newStock->decrement('jumlah_stok');
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
                $stock->increment('jumlah_stok');
            }

            $penjualan->delete();
            return redirect('/penjualan')->with('success', 'Data Penjualan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/penjualan')->withErrors('error', 'Penjualan gagal dihapus');
        }
    }
}
