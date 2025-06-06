<?php

namespace App\Http\Controllers;

use App\Models\TokoCabang;
use App\Http\Requests\TokoCabangRequest;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class TokoCabangController extends Controller
{

    /**
     * Validation role.
     */
    public function __construct()
    {
        $this->middleware('role:super_admin|owner')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toko_cabangs = TokoCabang::latest()->get();
        $userMap = User::pluck('name', 'username')->toArray();

        foreach ($toko_cabangs as $toko) {
            $toko->nama_penanggung_jawab = $userMap[$toko->penanggung_jawab_toko] ?? 'Tidak ada';
        }

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
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'super_admin');
        })->get();
        return view(
            'components.pages.toko-cabangs.create',
            [
                'title' => 'Tambah Toko Cabang',
                'users' => $users,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TokoCabangRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::where('username', $validatedData['penanggung_jawab_toko'])->first();
        $validatedData['penanggung_jawab_toko'] = $user->name;

        try {
            TokoCabang::create($validatedData);
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
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $toko_cabang = TokoCabang::findOrFail($id);
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'super_admin');
        })->get();
        return view(
            'components.pages.toko-cabangs.edit',
            [
                'title' => 'Edit Toko Cabang',
                'toko_cabang' => $toko_cabang,
                'users' => $users,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TokoCabangRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $user = User::where('username', $validatedData['penanggung_jawab_toko'])->first();
        $validatedData['penanggung_jawab_toko'] = $user->name;

        try {
            $toko_cabang = TokoCabang::findOrFail($id);
            $toko_cabang->update($validatedData);
            return redirect()->route('master-data.toko-cabang.index')->with('success', 'Toko cabang berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('master-data.toko-cabang.index')->with('error', 'Toko cabang gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $toko_cabang = TokoCabang::findOrFail($id);

        if ($toko_cabang->penjualans()->exists() || $toko_cabang->users()->exists()) {
            $message = 'Toko ' . $toko_cabang->nama_toko_cabang . ' tidak dapat dihapus karena memiliki data lain seperti ';
            $message .= $toko_cabang->penjualans()->exists() ? 'data penjualan' : '';
            $message .= $toko_cabang->penjualans()->exists() && $toko_cabang->users()->exists() ? ' dan ' : '';
            $message .= $toko_cabang->users()->exists() ? 'data user atau agen' : '';
            return redirect()->back()->with('message', $message . '.');
        }

        try {
            $toko_cabang->delete();
            return redirect()->route('master-data.toko-cabang.index')->with('success', 'Toko cabang berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting Toko Cabang: ' . $e->getMessage());
            return redirect()->route('master-data.toko-cabang.index')->with('error', 'Toko cabang gagal dihapus');
        }
    }
}
