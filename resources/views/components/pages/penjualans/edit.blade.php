@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <div class="gap-2 d-flex justify-content-between justify-content-sm-end">
                @if (!Auth::user()->hasRole('agen'))
                    <button type="button" class="btn btn-danger btn-sm d-inline-flex justify-content-center w-100"
                        data-bs-toggle="modal" data-bs-target="#modalPenjualanDelete">
                        <i class="bi bi-trash" style="margin: -2px 2px 0 0; font-size: 15px;"></i>
                        <span>Hapus</span>
                    </button>
                    <div class="modal fade text-left modal-borderless" id="modalPenjualanDelete" tabindex="-1"
                        aria-labelledby="modalPenjualanLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"
                            style="z-index: 30;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="modalPenjualanLabel">
                                        <i class="bi bi-exclamation-triangle-fill fs-5" style="margin-top:-8px;"></i>
                                        <span>Peringatan</span>
                                    </h5>
                                    <button type="button" class="close text-danger close-btn" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="bi bi-x-lg fs-6"></i>
                                        <span class="visually-hidden">Close</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Yakin Ingin Menghapus Data Ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-block">Batal</span>
                                    </button>
                                    <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST"
                                        id="formSubmitPopUp">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ms-1 d-inline-flex"
                                            id="submitBtnPopUp">
                                            <i class="bi bi-trash" style="margin: -1px 6px 0 0;"></i>
                                            <span class="d-none d-sm-block">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <a href="{{ route('penjualan.index') }}" role="button"
                    class="btn btn-secondary btn-sm d-inline-flex justify-content-center w-100">
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <section id="multiple-column-form">
            @session('error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession

            <div class="row">
                <div class="col-12">
                    <form action={{ route('penjualan.update', $penjualan->id) }} method="POST" class="form"
                        id="formSubmit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Data Penjualan</h5>
                                        <ul>
                                            <li>Kolom yang ditandai dengan <span class="text-danger">*</span> wajib diisi.
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="invoice" class="form-label">No. Invoice</label>
                                                <input type="text" id="invoice" name="invoice" readonly
                                                    class="form-control {{ $errors->has('invoice') ? 'is-invalid' : '' }}"
                                                    value="{{ old('invoice', $penjualan->invoice) }}">
                                                @error('invoice')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            @if (!Auth::user()->hasRole('agen'))
                                                <div class="col-md-6">
                                                    <label for="select-agent" class="form-label">Sales/Agent</label>
                                                    <select id="select-agent" name="user_id"
                                                        class="select-data form-select {{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                                                        data-placeholder="-- Pilih Sales/Agent --"
                                                        data-check-selected="true">
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ old('user_id', $penjualan->user_id) == $user->id ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="select-toko_cabangs" class="form-label">Toko Cabang</label>
                                                <select id="select-toko_cabangs" name="toko_cabang_id"
                                                    class="select-data form-select {{ $errors->has('toko_cabang_id') ? 'is-invalid' : '' }}"
                                                    data-placeholder="-- Pilih Toko Cabang --" data-check-selected="true">
                                                    @foreach ($toko_cabangs as $toko_cabang)
                                                        <option value="{{ $toko_cabang->id }}"
                                                            {{ old('toko_cabang_id', $penjualan->toko_cabang_id) == $toko_cabang->id ? 'selected' : '' }}>
                                                            {{ $toko_cabang->nama_toko_cabang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('toko_cabang_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="select-pelanggans" class="form-label">Pelanggan</label>
                                                <select id="select-pelanggans" name="pelanggan_id"
                                                    class="select-data form-select {{ $errors->has('pelanggan_id') ? 'is-invalid' : '' }}"
                                                    data-placeholder="-- Pilih Pelanggan --" data-check-selected="true">
                                                    @foreach ($pelanggans as $pelanggan)
                                                        <option value="{{ $pelanggan->id }}"
                                                            {{ old('pelanggan_id', $penjualan->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                                                            {{ $pelanggan->nama_pelanggan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('pelanggan_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="select-barang" class="form-label">Barang</label>
                                                <select id="select-barang" name="stock_id"
                                                    class="select-data form-select {{ $errors->has('stock_id') ? 'is-invalid' : '' }}"
                                                    data-placeholder="-- Pilih Barang --" data-check-selected="true"
                                                    data-penjualan-keterangan="{{ $penjualan->keterangan }}"
                                                    data-penjualan-garansi="{{ $penjualan->garansi }}" data-calc="true">
                                                    @foreach ($stocks as $stock)
                                                        <option value="{{ $stock->id }}"
                                                            data-price="{{ $stock->harga_jual }}"
                                                            data-garansi="{{ $stock->barang->garansi }}"
                                                            data-keterangan="{{ $stock->barang->keterangan }}"
                                                            {{ old('stock_id', $penjualan->stock_id) == $stock->id ? 'selected' : '' }}>
                                                            {{ $stock->barang->merk }} – {{ $stock->barang->nama_barang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('stock_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="qty" class="form-label">QTY (Jumlah Barang)</label>
                                                <input type="number" id="qty" name="qty" min="1"
                                                    value="{{ old('qty', $penjualan->qty) }}"
                                                    class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}">
                                                @error('qty')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="select-status" class="form-label">Status</label>
                                                <select id="select-status" name="status"
                                                    class="form-select {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                                    required>
                                                    <option value="proses"
                                                        {{ old('status', $penjualan->status) == 'proses' ? 'selected' : '' }}>
                                                        Proses
                                                    </option>
                                                    <option value="selesai"
                                                        {{ old('status', $penjualan->status) == 'selesai' ? 'selected' : '' }}>
                                                        Selesai
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="tanggal_transaksi" class="form-label">Tanggal
                                                    Transaksi</label>
                                                <input type="date" id="tanggal_transaksi" name="tanggal_transaksi"
                                                    class="form-control {{ $errors->has('tanggal_transaksi') ? 'is-invalid' : '' }}"
                                                    value="{{ old('tanggal_transaksi', $penjualan->tanggal_transaksi) }}"
                                                    required>
                                                @error('tanggal_transaksi')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <textarea id="keterangan" name="keterangan" rows="3"
                                                    class="form-control {{ $errors->has('keterangan') ? 'border-red-500' : 'border-gray-300' }}"
                                                    placeholder="Isi keterangan (jika perlu)">{{ old('keterangan', $penjualan->keterangan) }}</textarea>
                                                @error('keterangan')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input type="checkbox" id="garansi-checkbox" name="garansi"
                                                        class="form-check-input" value="ya"
                                                        {{ old('garansi', $penjualan->garansi) ? 'checked' : '' }}>
                                                    <label for="garansi-checkbox" class="form-check-label ms-2">
                                                        Garansi
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="text-secondary">Detail Penjualan</h5>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="mb-3 col-12">
                                                    <label for="sub-total" class="form-label">Sub Total</label>
                                                    <input type="text" id="sub-total" name="subtotal"
                                                        class="form-control {{ $errors->has('subtotal') ? 'is-invalid' : '' }}"
                                                        value="{{ old('subtotal', 'Rp ' . number_format($penjualan->subtotal, 0, ',', '.')) }}"
                                                        required>
                                                    @error('subtotal')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="mb-3 col-12">
                                                    <label for="diskon" class="form-label">Diskon (%)</label>
                                                    <input type="number" id="diskon" name="diskon" min="0"
                                                        max="100" value="{{ old('diskon', $penjualan->diskon) }}"
                                                        class="form-control {{ $errors->has('diskon') ? 'is-invalid' : '' }}">
                                                    @error('diskon')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="total-bayar" class="form-label">Total Bayar</label>
                                                    <input type="text" id="total-bayar" name="total_bayar" readonly
                                                        class="form-control {{ $errors->has('total_bayar') ? 'is-invalid' : '' }}"
                                                        value="{{ old('total_bayar', 'Rp ' . number_format($penjualan->total_bayar, 0, ',', '.')) }}"
                                                        required>
                                                    @error('total_bayar')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="mb-3 col-12">
                                                    <label for="metode-pembayaran" class="form-label">Metode
                                                        Pembayaran</label>
                                                    <select id="metode-pembayaran" name="metode_pembayaran"
                                                        class="form-select {{ $errors->has('metode_pembayaran') ? 'is-invalid' : '' }}"
                                                        required>
                                                        <option value="">-- Pilih Metode Pembayaran --</option>
                                                        <option value="tunai"
                                                            {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'tunai' ? 'selected' : '' }}>
                                                            Tunai
                                                        </option>
                                                        <option value="transfer"
                                                            {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>
                                                            Transfer
                                                        </option>
                                                        <option value="qris"
                                                            {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'qris' ? 'selected' : '' }}>
                                                            QRIS
                                                        </option>
                                                        <option value="e-wallet"
                                                            {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'e-wallet' ? 'selected' : '' }}>
                                                            E-Wallet
                                                        </option>
                                                    </select>
                                                    @error('metode_pembayaran')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            @if ($penjualan->status !== 'selesai')
                                                <div class="row mt-1">
                                                    <div class="col-12 d-flex justify-content-start">
                                                        <button type="submit" class="btn btn-primary me-3 mb-1"
                                                            id="submitBtn">
                                                            Edit
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>


@endsection

@push('scripts')
    {{-- @vite(['resources/js/choices.js', 'resources/js/calculate.js']) --}}
    <script type="module" src="{{ asset('build/assets/choices-HcjBDTwy.js') }}"></script>
    <script type="module" src="{{ asset('build/assets/calculate-BzQbymq7.js') }}"></script>
    @include('components.ui.loading.button')
@endpush
