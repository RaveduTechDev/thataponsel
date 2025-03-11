<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Requests\BarangRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::latest()->get();
        return view(
            'components.pages.barangs.index',
            [
                'title' => 'Data HP',
                'barangs' => $barangs,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'components.pages.barangs.create',
            [
                'title' => 'Tambah HP',
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BarangRequest $request)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data, $request) {
                if (Barang::where('kode_barang', $data['kode_barang'])
                    ->lockForUpdate()
                    ->exists()
                ) {
                    throw ValidationException::withMessages(['kode_barang' => 'Kode barang sudah ada']);
                }

                $barang = Barang::create($data);
                if ($request->hasFile('foto')) {
                    $barang->addMediaFromRequest('foto')
                        ->usingName($barang->nama_barang)
                        ->toMediaCollection('barang');
                }
            });
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }

        return redirect()->route('master-data.barang.index')->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return view(
            'components.pages.barangs.show',
            [
                'title' => 'Detail HP',
                'barang' => $barang,
            ]
        );
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
    public function update(BarangRequest $request, string $id)
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
