<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\TokoCabang;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Validation role.
     */
    public function __construct()
    {
        $this->middleware('role:super_admin|owner|admin')->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = '';
        $agents = [];
        $userRole = Auth::user()->getRoleNames()->first();

        if (Auth::user()->hasRole('super_admin')) {
            $title = 'Data User';
            $agents = User::latest()->get();
        } else {
            $title = Auth::user()->hasRole('admin') ? 'Data Agen' : (Auth::user()->hasRole('owner') ? 'Data User' : 'Data Agen');
            $agents = User::roleLogin($userRole)->latest()->get();
        }

        return view('components.pages.agents.index', [
            'title' => $title,
            'agents' => $agents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $toko_cabangs = TokoCabang::latest()->select('id', 'nama_toko_cabang')->get();
        return view('components.pages.agents.create', [
            'title' => 'Tambah Data',
            'toko_cabangs' => $toko_cabangs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        if (empty($validated['level']) && Auth::user()->hasRole('admin')) {
            $validated['level'] = 'agen';
        }

        $validated['password'] = Hash::make($validated['password']);

        try {
            $user = User::create($validated);
            $user->assignRole($validated['level']);

            return redirect()->route('master-data.agent.index')->with('success', 'Agen berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error creating agent: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan agen');
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
        $agent = User::findOrFail($id);
        $toko_cabangs = TokoCabang::latest()->select('id', 'nama_toko_cabang')->get();

        return view('components.pages.agents.edit', [
            'title' => 'Edit Data',
            'agent' => $agent,
            'toko_cabangs' => $toko_cabangs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $agent = User::findOrFail($id);
        $validated = $request->validated();

        if (empty($validated['level']) && Auth::user()->hasRole('admin') && $agent->hasRole('agen')) {
            $validated['level'] = 'agen';
        }

        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return redirect()->back()->withErrors(['current_password' => 'Password saat ini harus diisi untuk mengubah password']);
            }

            if (!Hash::check($request->input('current_password'), $agent->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }

            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        try {

            if (Auth::id() !== $agent->id) {
                $agent->update(['remember_token' => null]);
            }

            $agent->update($validated);
            $agent->syncRoles($validated['level']);

            return redirect()->route('master-data.agent.index')->with('success', 'Agen berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating agent: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui agen');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agent = User::findOrFail($id);

        if ($agent->penjualans()->exists() || $agent->jasaImei()->exists()) {
            $message = $agent->name . " tidak dapat dihapus karena memiliki data lain seperti ";
            $message .= $agent->penjualans()->exists() ? "data penjualan" : "";
            $message .= $agent->penjualans()->exists() && $agent->jasaImei()->exists() ? " dan " : "";
            $message .= $agent->jasaImei()->exists() ? "data jasa IMEI" : "";
            return redirect()->back()->with('message', $message . ".");
        }

        try {
            $agent->delete();
            DB::table('sessions')->where('user_id', $agent->id)->delete();

            return redirect()->route('master-data.agent.index')->with('success', 'Agen berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting agent: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus agen');
        }
    }
}
