<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\TokoCabang;
use App\Http\Requests\AgentRequest;
use Illuminate\Routing\Controller;

class AgentController extends Controller
{
    /**
     * Validation role.
     */
    public function __construct()
    {
        $this->middleware('role:super_admin|admin|agent')->only(['index', 'create', 'store', 'edit', 'update']);
        $this->middleware('role:super_admin|admin')->only(['destroy']);
    }

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
            'title' => 'Tambah Data Agen',
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
        $agent = Agent::findOrFail($id);
        $toko_cabangs = TokoCabang::select('id', 'nama_toko_cabang')->latest()->get();

        return view('components.pages.agents.edit', [
            'title' => 'Edit Agen',
            'agent' => $agent,
            'toko_cabangs' => $toko_cabangs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AgentRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            Agent::findOrFail($id)->update($data);
            return redirect('/master-data/agent')->with('success', 'Data agen berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Data agen gagal diubah.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Agent::findOrFail($id)->delete();
            return redirect('/master-data/agent')->with('success', 'Data agen berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Data agen gagal dihapus.');
        }
    }
}
