<?php

namespace App\Http\Controllers;

use App\Models\TokoCabang;
use App\Http\Requests\TokoCabangRequest;

class TokoCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toko_cabangs = TokoCabang::latest()->get();
        return view(
            'components.pages.toko-cabangs.index',
            [
                'title' => 'Data Toko Cabang',
                'toko_cabangs' => $toko_cabangs,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'components.pages.toko-cabangs.create',
            [
                'title' => 'Tambah Toko Cabang',
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TokoCabangRequest $request)
    {
        try {
            TokoCabang::create($request->validated());
            return redirect()->route('master-data.toko-cabang.index')->with('success', 'Toko cabang berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('master-data.toko-cabang.index')->with('error', 'Toko cabang gagal ditambahkan');
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
    public function update(TokoCabangRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $toko_cabang = TokoCabang::findOrFail($id);
        $toko_cabang->delete();

        return redirect('/master-data/toko-cabang')->with('success', 'Toko cabang berhasil dihapus');
    }
}
