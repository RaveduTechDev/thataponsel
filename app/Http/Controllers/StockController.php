<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Barang;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Controller;

class StockController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:super_admin|owner|admin|agen')->only('index');
        $this->middleware('role:super_admin|admin|agen')->only(['create', 'store', 'edit', 'update']);
        $this->middleware('role:super_admin|admin')->only('destroy');
        $this->middleware('role:super_admin|owner|admin')->only('show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::latest()->get();
        return view(
            'components.pages.stocks.index',
            [
                'title' => 'Stok HP',
                'stocks' => $stocks
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::latest()->get();
        return view(
            'components.pages.stocks.create',
            [
                'title' => 'Tambah Stok HP',
                'barangs' => $barangs
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();
        $data['garansi'] = ($request->has('garansi') && $request->garansi === 'ya') ? 'ya' : 'tidak';

        try {
            Stock::create($data);
            return redirect('/stocks')->with(['success' => 'Stok HP berhasil ditambahkan']);
        } catch (ValidationException $e) {
            Log::error($e->getMessage(
                'Error saat menambahkan stok HP: ' . $e->getMessage()
            ));
            return redirect('/stocks')->with(['error' => 'Stok HP gagal ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kode_barang)
    {
        $stock = Stock::findOrFail($kode_barang);
        return view(
            'components.pages.stocks.show',
            [
                'title' => 'Detail Stok HP',
                'stock' => $stock
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barangs = Barang::latest()->get();
        $stock = Stock::findOrFail($id);

        return view(
            'components.pages.stocks.edit',
            [
                'title' => 'Edit Stok HP',
                'stock' => $stock,
                'barangs' => $barangs
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockRequest $request, $id)
    {
        $data = $request->validated();
        $data['garansi'] = ($request->has('garansi') && $request->garansi === 'ya') ? 'ya' : 'tidak';

        try {
            Stock::findOrFail($id)->update($data);
            return redirect('/stocks')->with(['success' => 'Stok HP berhasil diubah']);
        } catch (ValidationException $e) {
            Log::error($e->getMessage(
                'Error saat mengubah stok HP: ' . $e->getMessage()
            ));
            return redirect('/stocks')->with(['error' => 'Stok HP gagal diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = Stock::findOrFail($id);

        // Check if stock has related penjualan
        if ($stock->penjualan()->exists()) {
            return redirect('/stocks')->with(['message' => 'Stok HP ' . $stock->barang->nama_barang . ' tidak dapat dihapus karena sudah ada penjualan yang terkait.']);
        }

        try {
            $stock->delete();
            return redirect('/stocks')->with(['success' => 'Stok HP berhasil dihapus']);
        } catch (\Exception $e) {
            Log::error('Error saat menghapus stok HP: ' . $e->getMessage());
            return redirect('/stocks')->with(['error' => 'Stok HP gagal dihapus']);
        }
    }
}
