@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Tambah Data Toko Cabang</h2>
            <a href={{ route('master-data.toko-cabang.index') }} style="margin:-8px 0 0 0;"
                class="d-inline-flex align-items-center btn btn-secondary btn-sm">
                <span>Kembali</span>
            </a>
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
                    <form action={{ route('master-data.toko-cabang.store') }} method="POST" class="form" id="formSubmit">
                        @csrf
                        <div class="row">
                            <div class=" col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="nama-toko-cabang" class="form-label">
                                                            Nama Toko Cabang
                                                        </label>
                                                        <input type="text" id="nama-toko-cabang"
                                                            class="form-control {{ $errors->has('nama_toko_cabang') ? 'is-invalid' : '' }}"
                                                            placeholder="Nama Toko Cabang" name="nama_toko_cabang"
                                                            value="{{ @old('nama_toko_cabang') }}" required>
                                                        @error('nama_toko_cabang')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="nama-penanggung-jawab-toko" class="form-label">
                                                            Nama Penanggung Jawab
                                                        </label>
                                                        <input type="text" id="nama-penanggung-jawab-toko"
                                                            class="form-control {{ $errors->has('penanggung_jawab_toko') ? 'is-invalid' : '' }}"
                                                            placeholder="Nama Penanggung Jawab" name="penanggung_jawab_toko"
                                                            value="{{ @old('penanggung_jawab_toko') }}" required>
                                                        @error('penanggung_jawab_toko')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="alamat-toko" class="form-label">
                                                            Alamat Toko
                                                        </label>
                                                        <textarea class="form-control {{ $errors->has('alamat_toko') ? 'is-invalid' : '' }} " name="alamat_toko"
                                                            id="alamat-toko" style="height: 180px;" placeholder="Alamat Toko" required></textarea>
                                                        @error('alamat_toko')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-success me-3 mb-1" id="submitBtn">
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
    {{-- @vite('resources/js/telInput.js') --}}
    {{-- <script type="module" src="{{ asset('build/assets/telInput-CYg8gn6C.js') }}"></script> --}}

    @include('components.ui.loading.button')
@endpush
