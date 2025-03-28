@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalStock">
                <i class="bi bi-trash" style="margin: -12px 2px 0 0; font-size: 18px;"></i>
                <span>Hapus</span>
            </button>
            <div class="modal fade text-left modal-borderless" id="modalStock" tabindex="-1"
                aria-labelledby="modalStockLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" role="document"
                    style="z-index: 30;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger" id="modalStockLabel">
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
                                <span class="d-none d-sm-block">Batal</span>
                            </button>

                            <form action={{ route('penjualan.destroy', $penjualan->id) }} method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ms-1 d-flex">
                                    <i class="bi bi-trash" style="margin: -1px 6px 0 0;"></i>
                                    <span class="d-none d-sm-block">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Data Penjualan</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="invoice" class="form-label">
                                                            No. Invoice
                                                        </label>
                                                        <input type="text" id="invoice" readonly
                                                            class="form-control {{ $errors->has('invoice') ? 'is-invalid' : '' }}"
                                                            placeholder="No. Invoice" name="invoice"
                                                            value="{{ $penjualan->invoice }}" required>
                                                        @error('invoice')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-agent" class="form-label">
                                                            Sales/Agent
                                                        </label>
                                                        <select id="select-agent" class="select-data form-select choice"
                                                            style="cursor:pointer;" name="agent_id"
                                                            data-placeholder="-- Pilih Sales/Agent --"
                                                            data-check-selected="true" required>
                                                            @foreach ($agents as $agent)
                                                                <option value="{{ $agent->id }}"
                                                                    {{ $penjualan->agent_id === $agent->id ? 'selected' : '' }}>
                                                                    {{ $agent->nama_agen }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('agent_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
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
                                                            data-check-selected="true" required>
                                                            @foreach ($toko_cabangs as $toko_cabang)
                                                                <option value="{{ $toko_cabang->id }}"
                                                                    {{ $penjualan->toko_cabang_id === $toko_cabang->id ? 'selected' : '' }}>
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
                                                            data-check-selected="true" data-calc="true" required>
                                                            @foreach ($stocks as $stock)
                                                                <option value="{{ $stock->id }}"
                                                                    data-price="{{ $stock->harga_jual }}"
                                                                    {{ $penjualan->stock_id === $stock->id ? 'selected' : '' }}>
                                                                    {{ $stock->barang->merk }} -
                                                                    {{ $stock->barang->nama_barang }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('stock_id"')
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
                                                            data-check-selected="true" required>
                                                            @foreach ($pelanggans as $pelanggan)
                                                                <option value="{{ $pelanggan->id }}"
                                                                    {{ $penjualan->pelanggan_id === $pelanggan->id ? 'selected' : '' }}>
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
                                                            name="status" data-check-selected="true" multiple required>
                                                            <option value="selesai"
                                                                {{ $penjualan->status == 'selesai' ? 'selected' : '' }}>
                                                                Selesai
                                                            </option>
                                                            <option value="proses"
                                                                {{ $penjualan->status == 'proses' ? 'selected' : '' }}>
                                                                Proses
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
                                                    <div class="form-group mandatory">
                                                        <label for="sub-total" class="form-label">
                                                            Sub Total
                                                        </label>
                                                        <input type="text" id="sub-total" min="0" readonly
                                                            class="form-control {{ $errors->has('subtotal') ? 'is-invalid' : '' }}"
                                                            placeholder="Sub Total" name="subtotal"
                                                            value="{{ $penjualan->subtotal }}" required>
                                                        @error('subtotal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="diskon" class="form-label">
                                                            Diskon (%)
                                                        </label>
                                                        <input
                                                            class="form-control {{ $errors->has('diskon') ? 'is-invalid' : '' }}"
                                                            type="number" id="diskon"
                                                            value="{{ $penjualan->diskon }}" min="0"
                                                            max="100" placeholder="No. Invoice" name="diskon">
                                                        @error('diskon')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="total-bayar" class="form-label">
                                                            Total Bayar
                                                        </label>
                                                        <input type="text" id="total-bayar" readonly
                                                            class="form-control {{ $errors->has('total_bayar') ? 'is-invalid' : '' }}"
                                                            placeholder="Total Bayar" name="total_bayar" min="0"
                                                            value="{{ $penjualan->total_bayar }}" data-check-value="true"
                                                            required>
                                                        @error('total_bayar')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary me-3 mb-1"
                                                        id="submitBtn">
                                                        Edit
                                                    </button>
                                                    <a href="{{ route('penjualan.index') }}"
                                                        class="btn btn-secondary me-3 mb-1">
                                                        Kembali
                                                    </a>
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

    @vite(['resources/js/choices.js', 'resources/js/choices-multi.js', 'resources/js/calculate.js'])
    @include('components.ui.loading.button')
@endsection
