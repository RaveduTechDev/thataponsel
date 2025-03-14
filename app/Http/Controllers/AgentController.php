<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\TokoCabang;
use App\Http\Requests\AgentRequest;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = Agent::latest()->get();
        return view('components.pages.agents.index', [
            'title' => 'Data Agen',
            'agents' => $agents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $toko_cabangs = TokoCabang::select('id', 'nama_toko_cabang')->latest()->get();
        return view('components.pages.agents.create', [
            'title' => 'Tambah Agen',
            'toko_cabangs' => $toko_cabangs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AgentRequest $request)
    {
        $data = $request->validated();

        try {
            Agent::create($data);
            return redirect('/master-data/agent')->with('success', 'Data agen berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Data agen gagal ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return abort(404);
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
    public function update(AgentRequest $request, string $id)
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
