<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agent;
use App\Models\JasaImei;
use App\Models\Pelanggan;
use App\Http\Requests\ImeiRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class JasaIMEIController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('role:super_admin|admin|agen|owner')->only('index');
        $this->middleware('role:super_admin|admin|owner')->only('show');
        $this->middleware('role:super_admin|admin|agen')->only(['create', 'store', 'edit', 'update']);
        $this->middleware('role:super_admin|admin')->only('destroy');
    }

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
        $users = User::latest()->get();
        return view('components.pages.imei.create', [
            'title' => 'Tambah Jasa Imei',
            'pelanggans' => $pelanggans,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImeiRequest $request)
    {
        $validated = $request->validated();

        if (empty($validated['user_id']) && Auth::user()->hasRole('agen')) {
            $validated['user_id'] = Auth::user()->id;
        }

        try {
            JasaImei::create($validated);
            return redirect('/jasa-imei')->with('success', 'Data jasa imei berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error creating Jasa Imei: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data jasa imei gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jasa_imei = JasaImei::findOrFail($id);
        return view('components.pages.imei.show', [
            'title' => 'Detail Jasa Imei',
            'jasa_imei' => $jasa_imei,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jasa_imei = JasaImei::findOrFail($id);
        $pelanggans = Pelanggan::latest()->get();
        $users = User::latest()->get();
        return view('components.pages.imei.edit', [
            'title' => 'Edit Jasa Imei',
            'jasa_imei' => $jasa_imei,
            'pelanggans' => $pelanggans,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ImeiRequest $request, string $id)
    {
        $validated = $request->validated();
        $validated['imei'] = $request->imei;
        if (empty($validated['user_id']) && Auth::user()->hasRole('agen')) {
            $validated['user_id'] = Auth::user()->id;
        }

        try {
            $jasa_imei = JasaImei::findOrFail($id);
            $jasa_imei->update($validated);
            return redirect('/jasa-imei')->with('success', 'Data jasa imei berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Error updating Jasa Imei: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data jasa imei gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $jasa_imei = JasaImei::findOrFail($id);
            $jasa_imei->delete();
            return redirect('/jasa-imei')->with('success', 'Data jasa imei berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data jasa imei gagal dihapus: ' . $e->getMessage());
        }
    }
}
