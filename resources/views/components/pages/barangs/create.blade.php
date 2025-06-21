@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <a href={{ route('master-data.barang.index') }} style="margin:-8px 0 0 0;"
                class="d-inline-flex align-items-center btn btn-secondary btn-sm">
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
                    <form action={{ route('master-data.barang.store') }} method="POST" enctype="multipart/form-data"
                        class="form" id="formSubmit">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-lg-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="kode-barang" class="form-label">Kode Barang</label>
                                                        <input type="text" id="kode-barang" readonly
                                                            class="form-control {{ $errors->has('kode_barang') ? 'is-invalid' : '' }}"
                                                            placeholder="Kode Barang" name="kode_barang"
                                                            value="{{ $kodeBarang }}" required>
                                                        @error('kode_barang')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-12">
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

                                                <div class="col-md-6 col-lg-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="merk" class="form-label">Merk</label>
                                                        <input type="text" id="merk"
                                                            class="form-control {{ $errors->has('merk') ? 'is-invalid' : '' }}"
                                                            placeholder="Merk" name="merk" value="{{ @old('merk') }}"
                                                            required>
                                                        @error('merk')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="tipe" class="form-label">Tipe</label>
                                                        <input type="text" id="tipe"
                                                            class="form-control {{ $errors->has('tipe') ? 'is-invalid' : '' }}"
                                                            placeholder="Tipe" name="tipe" value="{{ @old('tipe') }}"
                                                            required>
                                                        @error('tipe')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="memori" class="form-label">Memori</label>
                                                        <input type="text" id="memori"
                                                            class="form-control {{ $errors->has('memori') ? 'is-invalid' : '' }}"
                                                            placeholder="Memori" name="memori"
                                                            value="{{ @old('memori') }}" required>
                                                        @error('memori')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="warna" class="form-label">Warna</label>
                                                        <input type="text" id="warna"
                                                            class="form-control {{ $errors->has('warna') ? 'is-invalid' : '' }}"
                                                            placeholder="Warna" name="warna" value="{{ @old('warna') }}"
                                                            required>
                                                        @error('warna')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-12">
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

                                                <div class="col-md-6 col-lg-4 col-12">
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
                                                            <option value="iphone"
                                                                {{ old('kategori') === 'iphone' ? 'selected' : '' }}>
                                                                Iphone
                                                            </option>
                                                            <option value="smartwatch"
                                                                {{ old('kategori') === 'smartwatch' ? 'selected' : '' }}>
                                                                Smartwatch
                                                            </option>
                                                            <option value="smartband"
                                                                {{ old('kategori') === 'smartband' ? 'selected' : '' }}>
                                                                Smartband
                                                            </option>
                                                            <option value="ipad"
                                                                {{ old('kategori') === 'ipad' ? 'selected' : '' }}>
                                                                Ipad
                                                            </option>
                                                            <option value="tablet"
                                                                {{ old('kategori') === 'tablet' ? 'selected' : '' }}>
                                                                Tablet
                                                            </option>
                                                            <option value="earbuds"
                                                                {{ old('kategori') === 'earbuds' ? 'selected' : '' }}>
                                                                Earbuds/Headphones
                                                            </option>
                                                        </select>
                                                        @error('kategori')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="grade" class="form-label">Grade</label>
                                                        <input type="text" id="grade"
                                                            class="form-control {{ $errors->has('grade') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('grade') }}" placeholder="Grade"
                                                            name="grade" required>
                                                        @error('grade')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                        <textarea id="keterangan" name="keterangan" rows="5"
                                                            class="form-control w-full rounded {{ $errors->has('keterangan') ? 'border-red-500' : 'border-gray-300' }}"
                                                            placeholder="Isi keterangan (jika perlu)">{{ old('keterangan') }}</textarea>
                                                        @error('keterangan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
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
    @include('components.ui.loading.button')
@endpush
