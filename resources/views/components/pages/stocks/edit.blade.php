@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Edit Stok</h2>

            <button type="button" class="btn btn-danger btn-md" data-bs-toggle="modal" data-bs-target="#modalStock">
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

                            <form action={{ route('stocks.destroy', $stock->id) }} method="POST">
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
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession

            <div class="row match-height">
                <div class="col-12">
                    <form action={{ route('stocks.update', $stock->id) }} method="POST" enctype="multipart/form-data"
                        class="form" id="formSubmit">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                {{-- <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="kode-barang" class="form-label text-nowrap">
                                                            Kode Barang
                                                        </label>
                                                        <input type="text" id="kode-barang"
                                                            class="form-control {{ $errors->has('kode_barang') ? 'is-invalid' : '' }}"
                                                            placeholder="Kode Barang" name="kode_barang" required
                                                            value="{{ $stock->kode_barang }}" disabled>
                                                        @error('kode_barang')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="nama-barang" class="form-label text-nowrap">
                                                            Nama Barang
                                                        </label>
                                                        <input type="text" id="nama-barang"
                                                            class="form-control {{ $errors->has('nama_barang') ? 'is-invalid' : '' }}"
                                                            placeholder="Nama Barang" name="nama_barang" required
                                                            value="{{ $stock->nama_barang }}">
                                                        @error('nama_barang')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="satuan" class="form-label text-nowrap">Satuan</label>
                                                        <select id="satuan"
                                                            class="form-select {{ $errors->has('satuan') ? 'is-invalid' : '' }}"
                                                            style="cursor: pointer" name="satuan">
                                                            <option>-- Pilih Satuan --</option>
                                                            <option value="unit"
                                                                {{ $stock->satuan === 'unit' ? 'selected' : '' }}>Unit
                                                            </option>
                                                            <option value="fullset"
                                                                {{ $stock->satuan === 'fullset' ? 'selected' : '' }}>
                                                                Fullset
                                                            </option>

                                                        </select>
                                                        @error('satuan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="kategori"
                                                            class="form-label text-nowrap">Kategori</label>
                                                        <select id="kategori"
                                                            class="form-select {{ $errors->has('satuan') ? 'is-invalid' : '' }}"
                                                            style="cursor: pointer" name="kategori">
                                                            <option>-- Pilih Kategori --</option>
                                                            <option value="android"
                                                                {{ $stock->kategori === 'android' ? 'selected' : '' }}>
                                                                Android</option>
                                                            <option value="apple"
                                                                {{ $stock->kategori === 'apple' ? 'selected' : '' }}>Apple
                                                            </option>
                                                        </select>
                                                        @error('kategori')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="grade" class="form-label text-nowrap">Grade</label>
                                                        <input type="text" id="grade"
                                                            class="form-control {{ $errors->has('grade') ? 'is-invalid' : '' }}"
                                                            placeholder="Grade" name="grade" required
                                                            value="{{ $stock->grade }}">
                                                        @error('grade')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div> --}}

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-barangs" class="form-label">
                                                            Barang
                                                        </label>
                                                        <select id="select-barangs" class="select-data form-select choice"
                                                            style="cursor:pointer;" name="barang_id"
                                                            data-placeholder="-- Pilih Barang --" data-check-selected="true"
                                                            required>
                                                            @foreach ($barangs as $barang)
                                                                <option value="{{ $barang->id }}"
                                                                    {{ $stock->barang_id === $barang->id ? 'selected' : '' }}>
                                                                    {{ $barang->nama_barang }}
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
                                                            value="{{ $stock->supplier }}" placeholder="Supplier"
                                                            name="supplier" required>
                                                        @error('supplier')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="form-group d-flex flex-column">
                                                        <label for="phone" class="form-label">
                                                            No Kontak Supplier
                                                        </label>
                                                        <input id="phone" type="tel"
                                                            value="{{ $stock->no_kontak_supplier }}"
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
                                                            value="{{ $stock->tanggal }}" placeholder="tanggal"
                                                            name="tanggal" required>
                                                        @error('tanggal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="imei_1" class="form-label text-nowrap">
                                                            IMEI 1
                                                        </label>
                                                        <input type="text" id="imei_1"
                                                            class="form-control {{ $errors->has('imei_1') ? 'is-invalid' : '' }}"
                                                            placeholder="IMEI 1" name="imei_1"
                                                            value="{{ $stock->imei_1 }}">
                                                        @error('imei_1')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="imei_2" class="form-label text-nowrap">
                                                            IMEI 2
                                                        </label>
                                                        <input type="text" id="imei_2"
                                                            class="form-control {{ $errors->has('imei_2') ? 'is-invalid' : '' }}"
                                                            placeholder="IMEI 2" name="imei_2"
                                                            value="{{ $stock->imei_2 }}">
                                                        @error('imei_2')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="jumlah-stok" class="form-label text-nowrap">
                                                            Jumlah Stok</label>
                                                        <input type="number" min="1" id="jumlah-stok"
                                                            class="form-control {{ $errors->has('jumlah_stok') ? 'is-invalid' : '' }}"
                                                            placeholder="Jumlah Stock" name="jumlah_stok" required
                                                            value="{{ $stock->jumlah_stok }}">
                                                        @error('jumlah_stok')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="modal" class="form-label text-nowrap">Modal</label>
                                                        <input type="text" min="1" id="modal"
                                                            class="form-control {{ $errors->has('modal') ? 'is-invalid' : '' }}"
                                                            placeholder="IMEI 2" name="modal" required
                                                            value="{{ $stock->modal }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="harga-jual" class="form-label text-nowrap">
                                                            Harga Jual
                                                        </label>
                                                        <input type="text" min="1" id="harga-jual"
                                                            class="form-control {{ $errors->has('harga_jual') ? 'is-invalid' : '' }}"
                                                            placeholder="Harga Jual" name="harga_jual" required
                                                            value="{{ $stock->harga_jual }}">
                                                        @error('harga_jual')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="invoice"
                                                            class="form-label text-nowrap">Invoice</label>
                                                        <input type="text" min="1" id="invoice"
                                                            class="form-control {{ $errors->has('invoice') ? 'is-invalid' : '' }}"
                                                            placeholder="Invoice" name="invoice" required
                                                            value="{{ $stock->invoice }}">
                                                        @error('invoice')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="keterangan"
                                                            class="form-label text-nowrap">Keterangan</label>
                                                        <input type="text" min="1" id="keterangan"
                                                            class="form-control {{ $errors->has('keterangan') ? 'is-invalid' : '' }}"
                                                            placeholder="Keterangan" name="keterangan" required
                                                            value="{{ $stock->keterangan }}">
                                                        @error('keterangan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div> --}}

                                                <div class="col-12 mt-2">
                                                    <div class="form-group mandatory">
                                                        <div class="form-check mandatory">
                                                            <input type="checkbox" id="garansi"
                                                                class="form-check-input" style="cursor: pointer"
                                                                value="ya"
                                                                {{ $stock->garansi === 'ya' ? 'checked' : '' }}
                                                                name="garansi">
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
                                                    <button type="submit" class="btn btn-primary me-3 mb-1"
                                                        id="submitBtn">
                                                        <span>Ubah</span>
                                                    </button>
                                                    <a
                                                        href="{{ route('stocks.index') }}"class="btn btn-light-secondary me-3 mb-1">
                                                        <span>Kembali</span>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            {{-- <div class="col-md-4 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title text-nowrap">Upload Foto</h4>
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
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>

    @vite(['resources/js/choices.js', 'resources/js/telInput.js', 'resources/js/calculate2.js'])
    @include('components.ui.loading.button')

@endsection
