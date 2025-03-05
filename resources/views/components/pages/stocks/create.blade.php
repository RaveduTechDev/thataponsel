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
                            <div class="col-md-7 col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
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
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="imei_1" class="form-label">IMEI 1</label>
                                                        <input type="text" id="imei_1"
                                                            class="form-control {{ $errors->has('imei_1') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('imei_1') }}" placeholder="IMEI 1"
                                                            name="imei_1" required>
                                                        @error('imei_1')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="imei_2" class="form-label">IMEI 2</label>
                                                        <input type="text" id="imei_2"
                                                            class="form-control {{ $errors->has('imei_2') ? 'is-invalid' : '' }}"
                                                            placeholder="IMEI 2" name="imei_2"
                                                            value="{{ @old('imei_2') }}" required>
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
                                                        <input type="number" min="1" id="modal"
                                                            value="{{ @old('modal') }}"
                                                            class="form-control {{ $errors->has('modal') ? 'is-invalid' : '' }}"
                                                            placeholder="IMEI 2" name="modal" required>
                                                        @error('modal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="harga-jual" class="form-label">Harga Jual</label>
                                                        <input type="number" min="1" id="harga-jual"
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
                                                        <input type="number" min="1" id="invoice"
                                                            value="{{ @old('invoice') }}"
                                                            class="form-control {{ $errors->has('invoice') ? 'is-invalid' : '' }}"
                                                            placeholder="Invoice" name="invoice" required>
                                                        @error('invoice')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
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
                                                </div>

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

                            <div class="col-md-5 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Upload Foto</h4>
                                    </div>
                                    <div class="card-content" style="margin-top: -20px;">
                                        <div class="card-body">
                                            <input type="file" class="image-preview-filepond" name="foto">
                                            @error('foto')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
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

    @vite('resources/js/filepond.js')
    @include('components.ui.loading.button')
@endsection
