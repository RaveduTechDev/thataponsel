@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <div class="gap-2 d-flex justify-content-between justify-content-sm-end">
                @if (!Auth::user()->hasRole(['owner', 'agen']))
                    <button type="button" class="btn btn-danger btn-sm d-inline-flex justify-content-center w-100"
                        data-bs-toggle="modal" data-bs-target="#modalBarang">
                        <i class="bi bi-trash" style="margin: -2px 2px 0 0; font-size: 15px;"></i>
                        <span>Hapus</span>
                    </button>
                    <div class="modal fade text-left modal-borderless" id="modalBarang" tabindex="-1"
                        aria-labelledby="modalBarangLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"
                            style="z-index: 30;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="modalBarangLabel">
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
                                        <span class="d-block">Batal</span>
                                    </button>
                                    <form action="{{ route('master-data.barang.destroy', $barang->id) }}" method="POST"
                                        id="formSubmitPopUp">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ms-1 d-inline-flex"
                                            id="submitBtnPopUp">
                                            <i class="bi bi-trash" style="margin: -1px 6px 0 0;"></i>
                                            <span class="d-none d-sm-block">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <a href="{{ route('master-data.barang.index') }}"
                    class="btn btn-secondary btn-sm d-inline-flex justify-content-center w-100">
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
                    <form action={{ route('master-data.barang.update', $barang->kode_barang) }} method="POST"
                        enctype="multipart/form-data" class="form" id="formSubmit">
                        @csrf
                        @method('PUT')
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
                                                            value="{{ $barang->kode_barang }}" disabled required>
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
                                                            value="{{ $barang->nama_barang }}" required>
                                                        @error('nama_barang')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="merk" class="form-label">Merk</label>
                                                        <input type="text" id="merk"
                                                            class="form-control {{ $errors->has('merk') ? 'is-invalid' : '' }}"
                                                            placeholder="Merk" name="merk" value="{{ $barang->merk }}"
                                                            required>
                                                        @error('merk')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="tipe" class="form-label">Tipe</label>
                                                        <input type="text" id="tipe"
                                                            class="form-control {{ $errors->has('tipe') ? 'is-invalid' : '' }}"
                                                            placeholder="Tipe" name="tipe"
                                                            value="{{ $barang->tipe }}" required>
                                                        @error('tipe')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="memori" class="form-label">Memori</label>
                                                        <input type="text" id="memori"
                                                            class="form-control {{ $errors->has('memori') ? 'is-invalid' : '' }}"
                                                            placeholder="Memori" name="memori"
                                                            value="{{ $barang->memori }}" required>
                                                        @error('memori')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="warna" class="form-label">Warna</label>
                                                        <input type="text" id="warna"
                                                            class="form-control {{ $errors->has('warna') ? 'is-invalid' : '' }}"
                                                            placeholder="Warna" name="warna"
                                                            value="{{ $barang->warna }}" required>
                                                        @error('warna')
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
                                                                {{ $barang->satuan === 'unit' ? 'selected' : '' }}>Unit
                                                                Only
                                                            </option>
                                                            <option value="fullset"
                                                                {{ $barang->satuan === 'fullset' ? 'selected' : '' }}>
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
                                                        <label for="kategori" class="form-label">Kategori</label>
                                                        <select id="kategori"
                                                            class="form-select {{ $errors->has('satuan') ? 'is-invalid' : '' }}"
                                                            style="cursor: pointer" name="kategori" required>
                                                            <option>-- Pilih Kategori --</option>
                                                            <option value="android"
                                                                {{ $barang->kategori === 'android' ? 'selected' : '' }}>
                                                                Android
                                                            </option>
                                                            <option value="iphone"
                                                                {{ $barang->kategori === 'iphone' ? 'selected' : '' }}>
                                                                Iphone
                                                            </option>
                                                            <option value="smartwatch"
                                                                {{ $barang->kategori === 'smartwatch' ? 'selected' : '' }}>
                                                                Smartwatch
                                                            </option>
                                                            <option value="smartband"
                                                                {{ $barang->kategori === 'smartband' ? 'selected' : '' }}>
                                                                Smartband
                                                            </option>
                                                            <option value="ipad"
                                                                {{ $barang->kategori === 'ipad' ? 'selected' : '' }}>
                                                                Ipad
                                                            </option>
                                                            <option value="tablet"
                                                                {{ $barang->kategori === 'tablet' ? 'selected' : '' }}>
                                                                Tablet
                                                            </option>
                                                            <option value="earbuds"
                                                                {{ $barang->kategori === 'earbuds' ? 'selected' : '' }}>
                                                                Earbuds/Headphones
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
                                                            value="{{ $barang->grade }}" placeholder="Grade"
                                                            name="grade" required>
                                                        @error('grade')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                        <input type="text" min="1" id="keterangan"
                                                            value="{{ $barang->keterangan }}"
                                                            class="form-control {{ $errors->has('keterangan') ? 'is-invalid' : '' }}"
                                                            placeholder="Keterangan" name="keterangan">
                                                        @error('keterangan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
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
@endsection

@push('scripts')
    {{-- @vite('resources/js/filepond.js') --}}
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
            @if ($barang->getFirstMediaUrl('barang'))
                files: [{
                    source: "{{ $barang->getFirstMediaUrl('barang') }}",
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
