@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <div class="gap-2 d-flex justify-content-between justify-content-sm-end">
                <a href="{{ route('master-data.pelanggan.create') }}"
                    class="btn btn-success btn-sm d-inline-flex justify-content-center">
                    <i class="bi bi-plus-circle" style="margin: -2px 2px 0 0; font-size: 15px;"></i>
                    <span>Tambah Pelanggan</span>
                </a>

                <a href="{{ route('penjualan.index') }}"
                    class="btn btn-secondary btn-sm d-inline-flex justify-content-center">
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
                    <form action={{ route('penjualan.store') }} method="POST" class="form" id="formSubmit">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Data Penjualan</h5>
                                        <li>Kolom yang ditandai dengan <span class="text-danger">*</span> wajib diisi.</li>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="invoice" class="form-label">
                                                            No. Invoice
                                                        </label>
                                                        <input type="text" id="invoice" readonly
                                                            class="form-control {{ $errors->has('invoice') ? 'is-invalid' : '' }}"
                                                            placeholder="No. Invoice" name="invoice"
                                                            value="{{ $newInvoice }}" required>
                                                        @error('invoice')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                @if (!Auth::user()->hasRole('agen'))
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group mandatory">
                                                            <label for="select-agent" class="form-label">
                                                                Sales/Agent
                                                            </label>
                                                            <select id="select-agent" class="select-data form-select choice"
                                                                style="cursor:pointer;" name="user_id"
                                                                data-placeholder="-- Pilih Sales/Agent --"
                                                                data-check-selected="false">
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}"
                                                                        {{ old('user_id') === $user->id ? 'selected' : '' }}>
                                                                        {{ $user->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('user_id')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-toko_cabangs" class="form-label">
                                                            Toko Cabang
                                                        </label>
                                                        <select id="select-toko_cabangs"
                                                            class="select-data form-select choice" style="cursor:pointer;"
                                                            name="toko_cabang_id" data-placeholder="-- Pilih Toko Cabang --"
                                                            data-check-selected="false">
                                                            @foreach ($toko_cabangs as $toko_cabang)
                                                                <option value="{{ $toko_cabang->id }}"
                                                                    {{ old('toko_cabang_id') === $toko_cabang->id ? 'selected' : '' }}>
                                                                    {{ $toko_cabang->nama_toko_cabang }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('toko_cabang_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-pelanggans" class="form-label">
                                                            Pelanggan
                                                        </label>
                                                        <select id="select-pelanggans"
                                                            class="select-data form-select choice" style="cursor:pointer;"
                                                            name="pelanggan_id" data-placeholder="-- Pilih Pelanggan --"
                                                            data-check-selected="false">
                                                            @foreach ($pelanggans as $pelanggan)
                                                                <option value="{{ $pelanggan->id }}"
                                                                    {{ old('pelanggan_id') === $pelanggan->id ? 'selected' : '' }}>
                                                                    {{ $pelanggan->nama_pelanggan }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('pelanggan_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-barang" class="form-label">
                                                            Barang
                                                        </label>
                                                        <select id="select-barang" class="select-data form-select choice"
                                                            style="cursor:pointer;" name="stock_id"
                                                            data-placeholder="-- Pilih Barang --"
                                                            data-check-selected="false" data-calc="true">
                                                            @foreach ($stocks as $stock)
                                                                <option value="{{ $stock->id }}"
                                                                    data-price="{{ $stock->harga_jual }}"
                                                                    data-garansi="{{ $stock->garansi }}"
                                                                    data-keterangan="{{ $stock->keterangan }}"
                                                                    {{ old('stock_id') === $stock->id ? 'selected' : '' }}>
                                                                    {{ $stock->barang->nama_barang }} - {{ $stock->barang->memori }} - {{ $stock->barang->warna }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('stock_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="qty" class="form-label">
                                                            QTY (Jumlah Barang)
                                                        </label>
                                                        <input
                                                            class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}"
                                                            type="number" id="qty" value="1" min="1"
                                                            placeholder="No. Invoice" name="qty"
                                                            value="{{ @old('qty') }}" required>
                                                        @error('qty')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-status" class="form-label">
                                                            Status
                                                        </label>
                                                        <select id="select-status"
                                                            class="form-select {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                                            style="cursor:pointer;" name="status" required>
                                                            <option value="proses"
                                                                {{ old('status', isset($data) ? $data->status : '') == 'proses' ? 'selected' : '' }}>
                                                                Proses
                                                            </option>
                                                            <option value="selesai"
                                                                {{ old('status', isset($data) ? $data->status : '') == 'selesai' ? 'selected' : '' }}>
                                                                Selesai
                                                            </option>
                                                        </select>
                                                    </div>
                                                    @error('status')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="tanggal_transaksi" class="form-label">
                                                            Tanggal Transaksi
                                                        </label>
                                                        <input type="date" id="tanggal_transaksi"
                                                            class="form-control {{ $errors->has('tanggal_transaksi') ? 'is-invalid' : '' }}"
                                                            placeholder="Tanggal Transaksi" name="tanggal_transaksi"
                                                            value="{{ old('tanggal_transaksi') }}" required>
                                                        @error('tanggal_transaksi')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="keterangan" class="form-label">
                                                            Keterangan
                                                        </label>
                                                        <textarea id="keterangan" name="keterangan" rows="3"
                                                            class="form-control w-full rounded {{ $errors->has('keterangan') ? 'border-red-500' : 'border-gray-300' }}"
                                                            placeholder="Isi keterangan (jika perlu)">{{ old('keterangan') }}</textarea>
                                                        @error('keterangan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 mt-2">
                                                    <p style="margin: 0">
                                                        <span class="text-danger">*</span>
                                                        Centang opsi "<strong>Garansi</strong>" jika barang memiliki
                                                        garansi.
                                                    </p>
                                                </div>

                                                <div class="col-12 mt-1">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input type="checkbox" value="ya" id="garansi-checkbox"
                                                                name="garansi" class="form-check-input mr-2"
                                                                style="cursor:pointer;"
                                                                {{ old('garansi') ? 'checked' : '' }}>
                                                            <label for="garansi-checkbox" style="cursor:pointer;"
                                                                class="form-check-label form-label user-select-none">
                                                                Garansi
                                                            </label>
                                                        </div>
                                                    </div>
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
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="sub-total" class="form-label">
                                                            Sub Total
                                                        </label>
                                                        <input type="text" id="sub-total" min="0"
                                                            class="form-control {{ $errors->has('subtotal') ? 'is-invalid' : '' }}"
                                                            placeholder="Sub Total" name="subtotal"
                                                            value="{{ @old('subtotal') }}" required>
                                                        @error('subtotal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="diskon" class="form-label">
                                                            Diskon (%)
                                                        </label>
                                                        <input
                                                            class="form-control {{ $errors->has('diskon') ? 'is-invalid' : '' }}"
                                                            type="number" id="diskon" value="0" min="0"
                                                            max="100" placeholder="Diskon" name="diskon"
                                                            value="{{ @old('diskon') }}">
                                                        @error('diskon')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="total-bayar" class="form-label">
                                                            Total Bayar
                                                        </label>
                                                        <input type="text" id="total-bayar" readonly
                                                            class="form-control {{ $errors->has('total_bayar') ? 'is-invalid' : '' }}"
                                                            placeholder="Total Bayar" name="total_bayar" value="0"
                                                            min="0" value="{{ @old('total_bayar') }}" required>
                                                        @error('total_bayar')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="metode-pembayaran" class="form-label">
                                                            Metode Pembayaran
                                                        </label>
                                                        <select name="metode_pembayaran" id="metode-pembayaran"
                                                            class="form-select {{ $errors->has('metode_pembayaran') ? 'is-invalid' : '' }}"
                                                            style="cursor:pointer" required>
                                                            <option>-- Pilih Metode Pembayaran --</option>
                                                            <option value="tunai"
                                                                {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>
                                                                Tunai
                                                            </option>
                                                            <option value="transfer"
                                                                {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>
                                                                Transfer
                                                            </option>
                                                            <option value="qris"
                                                                {{ old('metode_pembayaran') == 'qris' ? 'selected' : '' }}>
                                                                QRIS
                                                            </option>
                                                            <option value="e-wallet"
                                                                {{ old('metode_pembayaran') == 'e-wallet' ? 'selected' : '' }}>
                                                                E-Wallet
                                                            </option>
                                                        </select>
                                                        @error('metode_pembayaran')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-1">
                                                <div class="col-12 d-flex justify-content-start">
                                                    <button type="submit" class="btn btn-success me-3 mb-1"
                                                        id="submitBtn">
                                                        Tambah
                                                    </button>
                                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                        Reset
                                                    </button>
                                                </div>
                                            </div>
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
