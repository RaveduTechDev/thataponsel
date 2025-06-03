<?php

namespace App\Http\Controllers;

use App\Http\Requests\PelangganRequest;
use App\Models\Pelanggan;
use Illuminate\Routing\Controller;

class PelangganController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('role:super_admin|admin|agen')->only(['index', 'create', 'store', 'edit', 'update']);
        $this->middleware('role:super_admin|admin')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = Pelanggan::latest()->get();
        return view(
            'components.pages.pelanggans.index',
            [
                'title' => 'Data Pelanggan',
                'pelanggans' => $pelanggans
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'components.pages.pelanggans.create',
            [
                'title' => 'Tambah Data Pelanggan'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PelangganRequest $request)
    {
        try {
            $data = $request->validated();
            Pelanggan::create($data);
            return redirect()->route('penjualan.create')->with('success', 'Data Pelanggan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Pelanggan gagal ditambahkan');
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
        $pelanggan = Pelanggan::findOrFail($id);
        return view(
            'components.pages.pelanggans.edit',
            [
                'title' => 'Edit Data Pelanggan',
                'pelanggan' => $pelanggan
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PelangganRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $pelanggan = Pelanggan::findOrFail($id);
            $pelanggan->update($data);
            return redirect()->route('master-data.pelanggan.index')->with('success', 'Data Pelanggan berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Pelanggan gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        if ($pelanggan->penjualans()->exists() || $pelanggan->jasaImeis()->exists()) {
            $message = $pelanggan->nama_pelanggan . ' tidak dapat dihapus karena memiliki data lain seperti ';
            $message .= $pelanggan->penjualans()->exists() ? 'data penjualan' : '';
            $message .= $pelanggan->penjualans()->exists() && $pelanggan->jasaImeis()->exists() ? ' dan ' : '';
            $message .= $pelanggan->jasaImeis()->exists() ? 'data jasa IMEI' : '';
            return redirect()->back()->with('message', $message . '.');
        }

        try {
            $pelanggan->delete();
            return redirect()->route('master-data.pelanggan.index')->with('success', 'Data Pelanggan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Pelanggan gagal dihapus');
        }
    }
}
