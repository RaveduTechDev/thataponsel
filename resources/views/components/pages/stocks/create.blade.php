@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Tambah Stok HP</h2>
            <a href={{ route('stocks.index') }} style="margin:-8px 0 0 0;"
                class="d-inline-flex align-items-center btn btn-secondary btn-md">
                <span>Kembali</span>
            </a>
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                {{-- <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="kode-barang" class="form-label">Kode Barang</label>
                                                        <input type="text" id="kode-barang"
                                                            class="form-control {{ $errors->has('kode_barang') ? 'is-invalid' : '' }}"
                                                            placeholder="Kode Barang" name="kode_barang"
                                                            value="{{ @old('kode_barang') }}" required>
                                                        @error('kode_barang')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="nama-barang" class="form-label">Nama Barang</label>
                                                        <input type="text" id="nama-barang"
                                                            class="form-control {{ $errors->has('nama_barang') ? 'is-invalid' : '' }}"
                                                            placeholder="Nama Barang" name="nama_barang"
                                                            value="{{ @old('nama_barang') }}" required>
                                                        @error('nama_barang')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="satuan" class="form-label">Satuan</label>
                                                        <select id="satuan"
                                                            class="form-select {{ $errors->has('satuan') ? 'is-invalid' : '' }}"
                                                            style="cursor: pointer" name="satuan" required>
                                                            <option>-- Pilih Satuan --</option>
                                                            <option value="unit"
                                                                {{ old('satuan') === 'unit' ? 'selected' : '' }}>Unit Only
                                                            </option>
                                                            <option value="fullset"
                                                                {{ old('satuan') === 'fullset' ? 'selected' : '' }}>Fullset
                                                            </option>
                                                        </select>
                                                        @error('satuan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="kategori" class="form-label">Kategori</label>
                                                        <select id="kategori"
                                                            class="form-select {{ $errors->has('satuan') ? 'is-invalid' : '' }}"
                                                            style="cursor: pointer" name="kategori" required>
                                                            <option>-- Pilih Kategori --</option>
                                                            <option value="android"
                                                                {{ old('kategori') === 'android' ? 'selected' : '' }}>
                                                                Android
                                                            </option>
                                                            <option value="apple"
                                                                {{ old('kategori') === 'apple' ? 'selected' : '' }}>
                                                                Apple
                                                            </option>
                                                        </select>
                                                        @error('kategori')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="grade" class="form-label">Grade</label>
                                                        <input type="text" id="grade"
                                                            class="form-control {{ $errors->has('grade') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('grade') }}" placeholder="Grade" name="grade"
                                                            required>
                                                        @error('grade')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-6 col-12 z-2">
                                                    <div class="form-group mandatory">
                                                        <label for="select-barangs" class="form-label">
                                                            Barang
                                                        </label>
                                                        <select id="select-barangs" class="select-data form-select choice"
                                                            style="cursor:pointer;" name="barang_id"
                                                            data-placeholder="-- Pilih Barang --"
                                                            data-check-selected="false" required>
                                                            @foreach ($barangs as $barang)
                                                                <option value="{{ $barang->id }}"
                                                                    {{ old('barang_id"') === $barang->id ? 'selected' : '' }}>
                                                                    {{ $barang->nama_barang }} - {{ $barang->merk }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('barang_id"')
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

                                                {{-- <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="no_kontak_supplier" class="form-label">
                                                            No Kontak Supplier
                                                        </label>
                                                        <input type="text" id="no_kontak_supplier"
                                                            class="form-control {{ $errors->has('no_kontak_supplier') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('no_kontak_supplier') }}"
                                                            placeholder="No Kontak Supplier" name="no_kontak_supplier">
                                                        @error('no_kontak_supplier')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div> --}}

                                                <div class="col-md-4 col-12">
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
                                                        <label for="modal" class="form-label">Modal</label>
                                                        <input type="text" id="modal" value="{{ @old('modal') }}"
                                                            class="form-control {{ $errors->has('modal') ? 'is-invalid' : '' }}"
                                                            placeholder="Rp. 0" name="modal" required>
                                                        @error('modal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
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

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="invoice" class="form-label">Invoice</label>
                                                        <input type="text" id="invoice"
                                                            value="{{ @old('invoice') }}"
                                                            class="form-control {{ $errors->has('invoice') ? 'is-invalid' : '' }}"
                                                            placeholder="Invoice" name="invoice" required>
                                                        @error('invoice')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                        <input type="text" min="1" id="keterangan"
                                                            value="{{ @old('keterangan') }}"
                                                            class="form-control {{ $errors->has('keterangan') ? 'is-invalid' : '' }}"
                                                            placeholder="Keterangan" name="keterangan" required>
                                                        @error('keterangan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div> --}}

                                                <div class="col-12 mt-2">
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

    @vite(['resources/js/choices.js', 'resources/js/telInput.js', 'resources/js/calculate2.js'])
    @include('components.ui.loading.button')
@endsection
