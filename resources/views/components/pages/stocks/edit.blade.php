@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('build/assets/telInput-D9_xf1bf.css') }}">
@endpush

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Edit Stok</h2>

            <div class="d-flex gap-2 justify-content-center align-items-center">
                <button type="button" class="btn btn-danger btn-sm d-inline-flex justify-content-center w-100"
                    data-bs-toggle="modal" data-bs-target="#modalStock">
                    <i class="bi bi-trash" style="margin: -2px 2px 0 0; font-size: 15px;"></i>
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

                <a href="{{ route('stocks.index') }}" class="btn btn-sm btn-secondary w-100">
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
                    <form action={{ route('stocks.update', $stock->id) }} method="POST" enctype="multipart/form-data"
                        class="form" id="formSubmit">
                        @csrf
                        @method('PUT')

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
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-barangs" class="form-label">
                                                            Barang
                                                        </label>
                                                        <select id="select-barangs" class="select-data form-select choice"
                                                            style="cursor:pointer;" name="barang_id"
                                                            data-placeholder="-- Pilih Barang --"
                                                            data-penjualan-keterangan="{{ $stock->keterangan }}"
                                                            data-check-selected="true" data-calc="true">
                                                            @foreach ($barangs as $barang)
                                                                <option value="{{ $barang->id }}"
                                                                    data-keterangan="{{ $barang->keterangan }}"
                                                                    {{ old('barang_id', $stock->barang_id) === $barang->id ? 'selected' : '' }}>
                                                                    {{ $barang->nama_barang }}
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

                                                <div class="col-md-6 col-12">
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
                                                    <div class="form-group">
                                                        <label for="invoice"
                                                            class="form-label text-nowrap">Invoice</label>
                                                        <input type="text" min="1" id="invoice"
                                                            class="form-control {{ $errors->has('invoice') ? 'is-invalid' : '' }}"
                                                            placeholder="Invoice" name="invoice"
                                                            value="{{ $stock->invoice }}">
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
                                                            value="{{ $stock->tanggal }}" placeholder="tanggal"
                                                            name="tanggal" required>
                                                        @error('tanggal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="keterangan" class="form-label">
                                                            Keterangan
                                                        </label>
                                                        <textarea id="keterangan" name="keterangan" rows="5"
                                                            class="form-control rounded {{ $errors->has('keterangan') ? 'border-red-500' : 'border-gray-300' }}"
                                                            placeholder="Isi keterangan (jika perlu)">{{ old('keterangan', $stock->keterangan) }}</textarea>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-md-4 col-12">
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

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="text-secondary">Detail Stok</h5>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="modal" class="form-label text-nowrap">Modal</label>
                                                        <input type="text" min="1" id="modal"
                                                            class="form-control {{ $errors->has('modal') ? 'is-invalid' : '' }}"
                                                            placeholder="IMEI 2" name="modal" required
                                                            value="{{ $stock->modal }}">
                                                        @error('modal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
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
                                            </div>

                                            <div class="row mt-1">
                                                <div class="col-12 d-flex justify-content-start">
                                                    <button type="submit" class="btn btn-primary me-3 mb-1"
                                                        id="submitBtn">
                                                        <span>Ubah</span>
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


    <script type="module" src="{{ asset('build/assets/choices-HcjBDTwy.js') }}"></script>

    <script type="module" src="{{ asset('build/assets/calculate2-BtYRnwgA.js') }}"></script>
    <script type="module" src="{{ asset('build/assets/telInput-qKZFCzb-.js') }}"></script>

    @include('components.ui.loading.button')

    <script type="module" src="{{ asset('static/js/filePound/file-upload.js') }}"></script>
    <script type="module">
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageCrop,
            FilePondPluginImageExifOrientation,
            FilePondPluginImageFilter,
            FilePondPluginImageResize,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType,
        )

        // Filepond: Basic
        FilePond.create(document.querySelector(".basic-filepond"), {
            credits: null,
            allowImagePreview: false,
            allowMultiple: false,
            allowFileEncode: false,
            required: false,
            storeAsFile: true,
        })

        // Filepond: Multiple Files
        FilePond.create(document.querySelector(".multiple-files-filepond"), {
            credits: null,
            allowImagePreview: false,
            allowMultiple: true,
            allowFileEncode: false,
            required: false,
            storeAsFile: true,
        })

        // Filepond: With Validation
        FilePond.create(document.querySelector(".with-validation-filepond"), {
            credits: null,
            allowImagePreview: false,
            allowMultiple: true,
            allowFileEncode: false,
            required: true,
            acceptedFileTypes: ["image/png"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    resolve(type)
                }),
            storeAsFile: true,
        })

        FilePond.create(document.querySelector(".imgbb-filepond"), {
            credits: null,
            allowImagePreview: false,
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort) => {
                    const formData = new FormData()
                    formData.append(fieldName, file, file.name)

                    const request = new XMLHttpRequest()
                    request.open(
                        "POST",
                        "https://api.imgbb.com/1/upload?key=762894e2014f83c023b233b2f10395e2"
                    )

                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total)
                    }

                    request.onload = function() {
                        if (request.status >= 200 && request.status < 300) {
                            load(request.responseText)
                        } else {
                            error("oh no")
                        }
                    }

                    request.onreadystatechange = function() {
                        if (this.readyState == 4) {
                            if (this.status == 200) {
                                let response = JSON.parse(this.responseText)

                                Toastify({
                                    text: "Success uploading to imgbb! see console f12",
                                    duration: 3000,
                                    close: true,
                                    gravity: "bottom",
                                    position: "right",
                                    backgroundColor: "#4fbe87",
                                }).showToast()
                            } else {
                                Toastify({
                                    text: "Failed uploading to imgbb! see console f12",
                                    duration: 3000,
                                    close: true,
                                    gravity: "bottom",
                                    position: "right",
                                    backgroundColor: "#ff0000",
                                }).showToast()
                            }
                        }
                    }

                    request.send(formData)
                },
            },
            storeAsFile: true,
        })

        FilePond.create(document.querySelector(".image-preview-filepond"), {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    resolve(type)
                }),
            storeAsFile: true,
            @if ($stock->getFirstMediaUrl('stock'))
                files: [{
                    source: "{{ $stock->getFirstMediaUrl('stock') }}",
                }]
            @elseif ($stock->barang->getFirstMediaUrl('barang'))
                files: [{
                    source: "{{ $stock->barang->getFirstMediaUrl('barang') }}",
                }]
            @endif
        })

        // Filepond: Image Crop
        FilePond.create(document.querySelector(".image-crop-filepond"), {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: true,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    resolve(type)
                }),
            storeAsFile: true,
        })

        // Filepond: Image Exif Orientation
        FilePond.create(document.querySelector(".image-exif-filepond"), {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: true,
            allowImageCrop: false,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    resolve(type)
                }),
            storeAsFile: true,
        })

        // Filepond: Image Filter
        FilePond.create(document.querySelector(".image-filter-filepond"), {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: true,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            imageFilterColorMatrix: [
                0.299, 0.587, 0.114, 0, 0, 0.299, 0.587, 0.114, 0, 0, 0.299, 0.587, 0.114,
                0, 0, 0.0, 0.0, 0.0, 1, 0,
            ],
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    resolve(type)
                }),
            storeAsFile: true,
        })
    </script>
@endpush
