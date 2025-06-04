@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('build/assets/telInput-D9_xf1bf.css') }}">
@endpush

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Tambah Stok HP</h2>

            <div class="d-flex gap-2 justify-content-center align-items-center">
                <a href="{{ route('stocks.index') }}" class="btn btn-sm btn-light-secondary w-100">
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <section id="multiple-column-form">
            @session('error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession

            <div class="row match-height">
                <div class="col-12">
                    <form action={{ route('stocks.store') }} method="POST" enctype="multipart/form-data" class="form"
                        id="formSubmit">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Data Stok Barang</h5>
                                        <li>Kolom yang ditandai dengan <span class="text-danger">*</span> wajib diisi.</li>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12 z-2">
                                                    <div class="form-group mandatory">
                                                        <label for="select-barangs" class="form-label">
                                                            Barang
                                                        </label>
                                                        <select id="select-barangs" class="select-data form-select choice"
                                                            style="cursor:pointer;" name="barang_id"
                                                            data-placeholder="-- Pilih Barang --"
                                                            {{ old('barang_id') ? 'data-check-selected=true' : 'data-check-selected="false"' }}
                                                            required>
                                                            @foreach ($barangs as $barang)
                                                                <option value="{{ $barang->id }}"
                                                                    {{ old('barang_id') === $barang->id ? 'selected' : '' }}>
                                                                    {{ $barang->nama_barang }} - {{ $barang->merk }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('barang_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="jumlah-stok" class="form-label">Jumlah Stok</label>
                                                        <input type="number" min="1" id="jumlah-stok"
                                                            value="{{ @old('jumlah_stok') }}"
                                                            class="form-control {{ $errors->has('jumlah_stok') ? 'is-invalid' : '' }}"
                                                            placeholder="Jumlah Stock" name="jumlah_stok" required>
                                                    </div>
                                                    @error('jumlah_stok')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="supplier" class="form-label">Supplier</label>
                                                        <input type="text" id="supplier"
                                                            class="form-control {{ $errors->has('supplier') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('supplier') }}" placeholder="Supplier"
                                                            name="supplier" required>
                                                        @error('supplier')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group d-flex flex-column">
                                                        <label for="phone" class="form-label">
                                                            No Kontak Supplier
                                                        </label>
                                                        <input id="phone" type="tel"
                                                            value="{{ old('no_kontak_supplier') }}"
                                                            class="form-control {{ $errors->has('no_kontak_supplier') ? 'is-invalid' : '' }}"
                                                            name="no_kontak_supplier">
                                                    </div>
                                                    @error('no_kontak_supplier')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="imei_1" class="form-label">IMEI 1</label>
                                                        <input type="text" id="imei_1"
                                                            class="form-control {{ $errors->has('imei_1') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('imei_1') }}" placeholder="IMEI 1"
                                                            name="imei_1">
                                                        @error('imei_1')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="imei_2" class="form-label">IMEI 2</label>
                                                        <input type="text" id="imei_2"
                                                            class="form-control {{ $errors->has('imei_2') ? 'is-invalid' : '' }}"
                                                            placeholder="IMEI 2" name="imei_2"
                                                            value="{{ @old('imei_2') }}">
                                                        @error('imei_2')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="invoice" class="form-label">Invoice</label>
                                                        <input type="text" id="invoice"
                                                            value="{{ @old('invoice') }}"
                                                            class="form-control {{ $errors->has('invoice') ? 'is-invalid' : '' }}"
                                                            placeholder="Invoice" name="invoice">
                                                        @error('invoice')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="tanggal" class="form-label">Tanggal</label>
                                                        <input type="date" id="tanggal"
                                                            class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('tanggal') }}" placeholder="tanggal"
                                                            name="tanggal" required>
                                                        @error('tanggal')
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
                                                        <div class="form-check mandatory">
                                                            <input type="checkbox" id="garansi"
                                                                class="form-check-input" style="cursor: pointer;"
                                                                value="ya" name="garansi"
                                                                {{ old('garansi') ? 'checked' : '' }}>
                                                            <label for="garansi" style="cursor:pointer;"
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
                                        <h5 class="text-secondary">Detail Stok</h5>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="modal" class="form-label">Modal</label>
                                                        <input type="text" id="modal" value="{{ @old('modal') }}"
                                                            class="form-control {{ $errors->has('modal') ? 'is-invalid' : '' }}"
                                                            placeholder="Rp. 0" name="modal" required>
                                                        @error('modal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="harga-jual" class="form-label">Harga Jual</label>
                                                        <input type="text" id="harga-jual"
                                                            value="{{ @old('harga_jual') }}"
                                                            class="form-control {{ $errors->has('harga_jual') ? 'is-invalid' : '' }}"
                                                            placeholder="Harga Jual" name="harga_jual" required>
                                                        @error('harga_jual')
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
    {{-- @vite(['resources/js/choices.js', 'resources/js/telInput.js', 'resources/js/calculate2.js']) --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script> --}}


    <script type="module" src="{{ asset('build/assets/choices-BGT1ZLBO.js') }}"></script>

    <script type="module" src="{{ asset('build/assets/calculate2-CM0A94sm.js') }}"></script>
    <script type="module" src="{{ asset('build/assets/telInput-qKZFCzb-.js') }}"></script>

    @include('components.ui.loading.button')
@endpush
