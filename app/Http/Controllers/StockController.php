<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
    public function store(StockRequest $request)
    {
        $data = $request->validated();
        $data['garansi'] = ($request->has('garansi') && $request->garansi === 'ya') ? 'ya' : 'tidak';
        $data['supplier'] = Auth::user()->name;
        $data['no_kontak_supplier'] = "08123456789";
        $data['tanggal'] = now();

        try {
            DB::transaction(function () use ($data, $request) {
                if (Stock::where('kode_barang', $data['kode_barang'])
                    ->lockForUpdate()
                    ->exists()
                ) {
                    throw new \Exception('Data sudah ada.');
                }
                Stock::create($data);

                if ($request->hasFile('foto')) {
                    $stock = Stock::where('kode_barang', $data['kode_barang'])->first();
                    $stock->addMediaFromRequest('foto')
                        ->usingName($stock->nama_barang)
                        ->toMediaCollection('stocks');
                }
            });

            return redirect('/stocks')->with(['success' => 'Stok HP berhasil ditambahkan']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan.']);
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
    public function edit(Stock $stock)
    {
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
    public function update(StockRequest $request, Stock $stock)
    {
        $data = $request->validated();
        $data['kode_barang'] = $stock->kode_barang;
        $data['garansi'] = ($request->has('garansi') && $request->garansi === 'ya') ? 'ya' : 'tidak';
        $data['supplier'] = Auth::user()->name;
        $data['no_kontak_supplier'] = "08123456789";
        $data['tanggal'] = now();

        try {
            DB::transaction(function () use ($data, $request, $stock) {
                $stock->update($data);

                if ($request->hasFile('foto')) {
                    $stock->clearMediaCollection('stocks');
                    $stock->addMediaFromRequest('foto')
                        ->usingName($stock->nama_barang)
                        ->toMediaCollection('stocks');
                }
            });

            return redirect('/stocks')->with(['success' => 'Stok HP berhasil diubah']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan.']);
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
