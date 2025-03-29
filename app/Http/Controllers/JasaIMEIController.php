<?php

namespace App\Http\Controllers;

use App\Models\JasaImei;
use Illuminate\Http\Request;

class JasaIMEIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jasa_imeis = JasaImei::latest()->get();
        return view('components.pages.imei.index', [
            'title' => 'Data Jasa Imei',
            'jasa_imeis' => $jasa_imeis,
        ]);
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
