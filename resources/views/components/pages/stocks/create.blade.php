@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('build/assets/telInput-D9_xf1bf.css') }}">
@endpush

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Tambah Stok HP</h2>

            <div class="d-flex gap-2 justify-content-center align-items-center">
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
                                                            data-placeholder="-- Pilih Barang --" data-calc="true"
                                                            {{ old('barang_id') ? 'data-check-selected=true' : 'data-check-selected="false"' }}>
                                                            @foreach ($barangs as $barang)
                                                                <option value="{{ $barang->id }}"
                                                                    data-keterangan="{{ $barang->keterangan }}"
                                                                    {{ old('barang_id') === $barang->id ? 'selected' : '' }}>
                                                                    {{ $barang->nama_barang }} - {{ $barang->memori }} -
                                                                    {{ $barang->warna }}
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
                                                            class="form-control number-format {{ $errors->has('jumlah_stok') ? 'is-invalid' : '' }}"
                                                            placeholder="Jumlah Stock" name="jumlah_stok" required>
                                                    </div>
                                                    <small class="text-danger error-number-format"></small>

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
                                                            class="form-control number-format {{ $errors->has('imei_1') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('imei_1') }}" placeholder="IMEI 1"
                                                            name="imei_1">
                                                        <small class="text-danger error-number-format"></small>
                                                        @error('imei_1')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="imei_2" class="form-label">IMEI 2</label>
                                                        <input type="text" id="imei_2"
                                                            class="form-control number-format {{ $errors->has('imei_2') ? 'is-invalid' : '' }}"
                                                            placeholder="IMEI 2" name="imei_2"
                                                            value="{{ @old('imei_2') }}">
                                                        <small class="text-danger error-number-format"></small>
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
                                                            class="form-control number-format {{ $errors->has('invoice') ? 'is-invalid' : '' }}"
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


                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="keterangan" class="form-label">
                                                            Keterangan
                                                        </label>
                                                        <textarea id="keterangan" name="keterangan" rows="5"
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
                                                            <input type="checkbox" value="ya" id="garansi"
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


    <script type="module" src="{{ asset('build/assets/choices-HcjBDTwy.js') }}"></script>

    <script type="module" src="{{ asset('build/assets/calculate2-BtYRnwgA.js') }}"></script>
    <script type="module" src="{{ asset('build/assets/telInput-qKZFCzb-.js') }}"></script>

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

        // Filepond: Image Resize
        FilePond.create(document.querySelector(".image-resize-filepond"), {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            allowImageResize: true,
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,
            imageResizeMode: "cover",
            imageResizeUpscale: true,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    resolve(type)
                }),
            storeAsFile: true,
        })
    </script>

    <script>
        const numberTypes = document.querySelectorAll('.number-format');
        const errorNumberFormat = document.querySelectorAll('.error-number-format');

        numberTypes.forEach((input, index) => {
            input.addEventListener('input', function() {
                const invalidNumbers = /[^0-9]/g;
                if (invalidNumbers.test(this.value)) {
                    errorNumberFormat[index].textContent = "Karakter hanya boleh mengandung angka.";
                    setTimeout(() => {
                        errorNumberFormat[index].textContent = "";
                    }, 4000);
                }
                this.value = this.value.replace(invalidNumbers, "");
            });
        })
    </script>

    @include('components.ui.loading.button')
@endpush
