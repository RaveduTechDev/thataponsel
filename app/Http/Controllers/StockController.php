<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::latest()->get();
        return view(
            'components.pages.stocks.index',
            [
                'title' => 'Stok HP',
                'stocks' => $stocks
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // create form
        return view(
            'components.pages.stocks.create',
            [
                'title' => 'Tambah Stok HP'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['garansi'] = isset($data['garansi']) && $data['garansi'] == 1 ? 'ya' : 'tidak';
            $data['supplier'] = Auth::user()->name;
            $data['no_kontak_supplier'] = "08123456789";
            $data['tanggal'] = now();

            $stocks = Stock::create($data);
            if ($request->hasFile('foto')) {
                $stocks->addMediaFromRequest('foto')
                    ->usingName($stocks->nama_barang)
                    ->toMediaCollection('stocks');
            }

            return redirect('/stocks')->with(['success' => 'Stok HP berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kode_barang)
    {
        $stock = Stock::findOrFail($kode_barang);
        return view(
            'components.pages.stocks.show',
            [
                'title' => 'Detail Stok HP',
                'stock' => $stock
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $kode_barang)
    {
        $stock = Stock::findOrFail($kode_barang);

        return view(
            'components.pages.stocks.edit',
            [
                'title' => 'Edit Stok HP',
                'stock' => $stock,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->all();
            $data['garansi'] = ($request->has('garansi') && $request->garansi === 'ya') ? 'ya' : 'tidak';

            $stock = Stock::findOrFail($id);
            $stock->update($data);

            if ($request->hasFile('foto')) {
                $stock->clearMediaCollection('stocks');
                $stock->addMediaFromRequest('foto')
                    ->usingName($stock->nama_barang)
                    ->toMediaCollection('stocks');
            }

            return redirect('/stocks')->with(['success' => 'Stok HP berhasil diubah']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete data and delete image
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return redirect('/stocks')->with(['success' => 'Stok HP berhasil dihapus']);
    }
}
