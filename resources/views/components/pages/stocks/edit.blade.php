@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Edit Stok</h2>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalStock">
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
                    {{-- <form action={{ route('stocks.store') }} method="POST" enctype="multipart/form-data" class="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Stock Details</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="kode-barang" class="form-label">Kode Barang</label>
                                                        <input type="text" id="kode-barang" class="form-control"
                                                            placeholder="Kode Barang" name="kode_barang"
                                                            data-parsley-required="true" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="nama-barang" class="form-label">Nama Barang</label>
                                                        <input type="text" id="nama-barang" class="form-control"
                                                            placeholder="Nama Barang" name="nama_barang"
                                                            data-parsley-required="true" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="satuan" class="form-label">Satuan</label>
                                                        <select id="satuan" class="form-select" style="cursor: pointer"
                                                            name="satuan" data-parsley-required="true">
                                                            <option value="unit">Unit Only</option>
                                                            <option value="fullset">Fullset</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="kategori" class="form-label">Kategori</label>
                                                        <select id="kategori" class="form-select" style="cursor: pointer"
                                                            name="kategori" data-parsley-required="true">
                                                            <option>-- Pilih Kategori --</option>
                                                            <option value="android">Android</option>
                                                            <option value="apple">Apple</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="grade" class="form-label">Grade</label>
                                                        <input type="text" id="grade" class="form-control"
                                                            placeholder="Grade" name="grade" data-parsley-required="true"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="imei_1" class="form-label">IMEI 1</label>
                                                        <input type="text" id="imei_1" class="form-control"
                                                            placeholder="IMEI 1" name="imei_1" data-parsley-required="true"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="imei_2" class="form-label">IMEI 2</label>
                                                        <input type="text" id="imei_2" class="form-control"
                                                            placeholder="IMEI 2" name="imei_2"
                                                            data-parsley-required="true" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="jumlah-stok" class="form-label">Jumlah Stok</label>
                                                        <input type="number" min="1" id="jumlah-stok"
                                                            class="form-control" placeholder="Jumlah Stock"
                                                            name="jumlah_stok" data-parsley-required="true" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="modal" class="form-label">Modal</label>
                                                        <input type="number" min="1" id="modal"
                                                            class="form-control" placeholder="IMEI 2" name="modal"
                                                            data-parsley-required="true" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="harga-jual" class="form-label">Harga Jual</label>
                                                        <input type="number" min="1" id="harga-jual"
                                                            class="form-control" placeholder="Harga Jual"
                                                            name="harga_jual" data-parsley-required="true" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="invoice" class="form-label">Invoice</label>
                                                        <input type="number" min="1" id="invoice"
                                                            class="form-control" placeholder="Invoice" name="invoice"
                                                            data-parsley-required="true" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                        <input type="text" min="1" id="keterangan"
                                                            class="form-control" placeholder="Keterangan"
                                                            name="keterangan" data-parsley-required="true" required>
                                                    </div>
                                                </div>

                                                <div class="col-12 mt-2">
                                                    <div class="form-group">
                                                        <div class="form-check mandatory">
                                                            <input type="checkbox" id="garansi"
                                                                class="form-check-input" data-parsley-required="true"
                                                                style="cursor: pointer" value="1"
                                                                data-parsley-error-message="You have to accept our terms and conditions to proceed."
                                                                data-parsley-multiple="garansi">
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
                                                    <button type="submit" class="btn btn-success me-3 mb-1">
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

                            <div class="col-md-4 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Upload Image</h4>
                                    </div>
                                    <div class="card-content" style="margin-top: -20px;">
                                        <div class="card-body">
                                            <input type="file" class="image-preview-filepond" name="foto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form> --}}

                    {{-- update - $stock --}}
                    <form action={{ route('stocks.update', $stock->id) }} method="POST" enctype="multipart/form-data"
                        class="form">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8 col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="kode-barang" class="form-label text-nowrap">Kode
                                                            Barang</label>
                                                        <input type="text" id="kode-barang" class="form-control"
                                                            placeholder="Kode Barang" name="kode_barang"
                                                            data-parsley-required="true" required
                                                            value="{{ $stock->kode_barang }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="nama-barang" class="form-label text-nowrap">Nama
                                                            Barang</label>
                                                        <input type="text" id="nama-barang" class="form-control"
                                                            placeholder="Nama Barang" name="nama_barang"
                                                            data-parsley-required="true" required
                                                            value="{{ $stock->nama_barang }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="satuan" class="form-label text-nowrap">Satuan</label>
                                                        <select id="satuan" class="form-select" style="cursor: pointer"
                                                            name="satuan" data-parsley-required="true">
                                                            <option value="unit">Unit Only</option>
                                                            <option value="fullset">Fullset</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="kategori"
                                                            class="form-label text-nowrap">Kategori</label>
                                                        <select id="kategori" class="form-select" style="cursor: pointer"
                                                            name="kategori" data-parsley-required="true">
                                                            <option>-- Pilih Kategori --</option>
                                                            <option value="android"
                                                                {{ $stock->kategori === 'android' ? 'selected' : '' }}>
                                                                Android</option>
                                                            <option value="apple"
                                                                {{ $stock->kategori === 'apple' ? 'selected' : '' }}>Apple
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="grade" class="form-label text-nowrap">Grade</label>
                                                        <input type="text" id="grade" class="form-control"
                                                            placeholder="Grade" name="grade"
                                                            data-parsley-required="true" required
                                                            value="{{ $stock->grade }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="imei_1" class="form-label text-nowrap">IMEI
                                                            1</label>
                                                        <input type="text" id="imei_1" class="form-control"
                                                            placeholder="IMEI 1" name="imei_1"
                                                            data-parsley-required="true" required
                                                            value="{{ $stock->imei_1 }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="imei_2" class="form-label text-nowrap">IMEI
                                                            2</label>
                                                        <input type="text" id="imei_2" class="form-control"
                                                            placeholder="IMEI 2" name="imei_2"
                                                            data-parsley-required="true" required
                                                            value="{{ $stock->imei_2 }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="jumlah-stok" class="form-label text-nowrap">Jumlah
                                                            Stok</label>
                                                        <input type="number" min="1" id="jumlah-stok"
                                                            class="form-control" placeholder="Jumlah Stock"
                                                            name="jumlah_stok" data-parsley-required="true" required
                                                            value="{{ $stock->jumlah_stok }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="modal" class="form-label text-nowrap">Modal</label>
                                                        <input type="number" min="1" id="modal"
                                                            class="form-control" placeholder="IMEI 2" name="modal"
                                                            data-parsley-required="true" required
                                                            value="{{ $stock->modal }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="harga-jual" class="form-label text-nowrap">Harga
                                                            Jual</label>
                                                        <input type="number" min="1" id="harga-jual"
                                                            class="form-control" placeholder="Harga Jual"
                                                            name="harga_jual" data-parsley-required="true" required
                                                            value="{{ $stock->harga_jual }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="invoice"
                                                            class="form-label text-nowrap">Invoice</label>
                                                        <input type="number" min="1" id="invoice"
                                                            class="form-control" placeholder="Invoice" name="invoice"
                                                            data-parsley-required="true" required
                                                            value="{{ $stock->invoice }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="keterangan"
                                                            class="form-label text-nowrap">Keterangan</label>
                                                        <input type="text" min="1" id="keterangan"
                                                            class="form-control" placeholder="Keterangan"
                                                            name="keterangan" data-parsley-required="true" required
                                                            value="{{ $stock->keterangan }}">
                                                    </div>
                                                </div>

                                                <div class="col-12 mt-2">
                                                    <div class="form-group mandatory">
                                                        <div class="form-check mandatory">
                                                            <input type="checkbox" id="garansi"
                                                                class="form-check-input" data-parsley-required="true"
                                                                style="cursor: pointer" value="ya"
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
                                                    <button type="submit" class="btn btn-primary me-3 mb-1">
                                                        <span>Ubah</span>
                                                    </button>
                                                    <a href="{{ route('stocks.index') }}"class="btn btn-light-secondary">
                                                        <span>Kembali</span>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title text-nowrap">Upload Image</h4>
                                    </div>

                                    <div class="card-content" style="margin-top: -20px;">
                                        <div class="card-body">
                                            <input type="file" class="image-preview-filepond" name="foto">
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

    {{-- @vite('resources/js/filepond.js') --}}
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview, )
        FilePond.create(document.querySelector(".image-preview-filepond"), {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    // Do custom type detection here and return with promise
                    resolve(type)
                }),
            storeAsFile: true,
            @if ($stock->getFirstMediaUrl('stocks'))
                files: [{
                    source: "{{ $stock->getFirstMediaUrl('stocks') }}",
                }]
            @endif
        })
    </script>

@endsection
