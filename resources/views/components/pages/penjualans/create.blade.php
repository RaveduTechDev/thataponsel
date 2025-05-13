@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <div class="d-flex justify-content-between flex-column flex-sm-row align-items-sm-center">
                <a href="{{ route('penjualan.index') }}"
                    class="btn btn-secondary btn-sm d-inline-flex justify-content-center w-100 w-sm-auto">
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-3 text-secondary">Data Penjualan</h5>
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
                                                                data-check-selected="false" required>
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
                                                            data-check-selected="false" required>
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
                                                        <label for="select-barang" class="form-label">
                                                            Barang
                                                        </label>
                                                        <select id="select-barang" class="select-data form-select choice"
                                                            style="cursor:pointer;" name="stock_id"
                                                            data-placeholder="-- Pilih Toko Cabang --"
                                                            data-check-selected="false" data-calc="true" required>
                                                            @foreach ($stocks as $stock)
                                                                <option value="{{ $stock->id }}"
                                                                    data-price="{{ $stock->harga_jual }}"
                                                                    {{ old('stock_id') === $stock->id ? 'selected' : '' }}>
                                                                    {{ $stock->barang->merk }} -
                                                                    {{ $stock->barang->nama_barang }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('barang_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-pelanggans" class="form-label">
                                                            Pelanggan
                                                        </label>
                                                        <select id="select-pelanggans"
                                                            class="select-data form-select choice" style="cursor:pointer;"
                                                            name="pelanggan_id" data-placeholder="-- Pilih Pelanggan --"
                                                            data-check-selected="false" required>
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

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-status" class="form-label">
                                                            Status
                                                        </label>
                                                        <select id="select-status"
                                                            class="select-status form-select choices multiple-remove"
                                                            name="status" data-check-selected="false" multiple required>
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
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="sub-total" class="form-label">
                                                            Sub Total
                                                        </label>
                                                        <input type="text" id="sub-total" min="0" readonly
                                                            class="form-control {{ $errors->has('subtotal') ? 'is-invalid' : '' }}"
                                                            placeholder="No. Invoice" name="subtotal"
                                                            value="{{ @old('subtotal') }}" required>
                                                        @error('subtotal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="diskon" class="form-label">
                                                            Diskon (%)
                                                        </label>
                                                        <input
                                                            class="form-control {{ $errors->has('diskon') ? 'is-invalid' : '' }}"
                                                            type="number" id="diskon" value="0" min="0"
                                                            max="100" placeholder="No. Invoice" name="diskon"
                                                            value="{{ @old('diskon') }}">
                                                        @error('diskon')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
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
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group madatory">
                                                        <label for="metode-pembayaran" class="form-label">
                                                            Metode Pembayaran
                                                        </label>
                                                        <select name="metode_pembayaran" id="metode-pembayaran"
                                                            style="cursor:pointer"
                                                            class="form-select {{ $errors->has('metode_pembayaran') ? 'is-invalid' : '' }}">
                                                            <option>-- Pilih Metode Pembayaran--</option>
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
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
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
    @vite(['resources/js/choices.js', 'resources/js/calculate.js'])
    @include('components.ui.loading.button')
@endpush
