<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenjualanRequest;
use App\Models\Agent;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Stock;
use App\Models\TokoCabang;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

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
            Penjualan::create($data);
            return redirect()->route('penjualan.index')->with('success', 'Data Penjualan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Penjualan gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
