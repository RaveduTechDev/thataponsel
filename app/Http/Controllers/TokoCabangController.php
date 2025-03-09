<?php

namespace App\Http\Controllers;

use App\Models\TokoCabang;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
