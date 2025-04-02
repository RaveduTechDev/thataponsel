<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImeiRequest;
use App\Models\Agent;
use App\Models\JasaImei;
use App\Models\Pelanggan;
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
        $pelanggans = Pelanggan::latest()->get();
        $agents = Agent::latest()->get();
        return view('components.pages.imei.create', [
            'title' => 'Tambah Jasa Imei',
            'pelanggans' => $pelanggans,
            'agents' => $agents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImeiRequest $request)
    {
        $validated = $request->validated();

        try {
            JasaImei::create($validated);
            return redirect('/jasa-imei')->with('success', 'Data jasa imei berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Data jasa imei gagal ditambahkan: ' . $e->getMessage());
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
