<?php

namespace App\Http\Controllers;

use App\Helpers\KodeBarangGenerator;
use App\Models\Barang;
use App\Http\Requests\BarangRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Controller;


class BarangController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:super_admin|admin|owner|agen')->only('index');
        $this->middleware('role:super_admin|admin|agen')->only(['create', 'store', 'edit', 'update']);
        $this->middleware('role:super_admin|admin|owner')->only('show');
        $this->middleware('role:super_admin|admin')->only('destroy');
    }
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
        $kodeBarang = KodeBarangGenerator::generateKode();
        return view(
            'components.pages.barangs.create',
            [
                'title' => 'Tambah HP',
                'kodeBarang' => $kodeBarang,
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
            DB::transaction(function () use ($data) {
                if (Barang::where('kode_barang', $data['kode_barang'])
                    ->lockForUpdate()
                    ->exists()
                ) {
                    throw ValidationException::withMessages(['kode_barang' => 'Kode barang sudah ada']);
                }

                Barang::create($data);
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
    public function edit(Barang $barang)
    {
        return view(
            'components.pages.barangs.edit',
            [
                'title' => 'Edit HP',
                'barang' => $barang,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BarangRequest $request, Barang $barang)
    {
        // update
        $data = $request->validated();
        $data['kode_barang'] = $barang->kode_barang;

        try {
            DB::transaction(function () use ($data, $barang) {
                $barang->update($data);
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }

        return redirect('/master-data/barang')->with('success', 'Data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->stocks()->exists()) {
            return redirect()->back()->with('message', $barang->nama_barang . ' tidak dapat dihapus karena masih memiliki data stok yang terkait.');
        }

        try {
            $barang->clearMediaCollection('barang');
            $barang->delete();
            return redirect('/master-data/barang')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
