@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <a href={{ route('penjualan.index') }} style="margin:-8px 0 0 0;"
                class="d-inline-flex align-items-center btn btn-secondary btn-md">
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
                    <form action={{ route('penjualan.store') }} method="POST" class="form" id="formSubmit">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Data Penjualan</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="nama-agen" class="form-label">
                                                            No. Invoice
                                                        </label>
                                                        <input type="text" id="nama-agen"
                                                            class="form-control {{ $errors->has('nama_agen') ? 'is-invalid' : '' }}"
                                                            placeholder="No. Invoice" name="nama_agen"
                                                            value="{{ @old('nama_agen') }}" required>
                                                        @error('nama_agen')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="sales-agent" class="form-label">
                                                            Sales/Agent
                                                        </label>
                                                        <select id="select-agent" class="select-data form-select choice"
                                                            style="cursor:pointer;" name="agent_id" id="sales-agent"
                                                            data-placeholder="-- Pilih Sales/Agent --"
                                                            data-check-selected="false" required>
                                                            @foreach ($agents as $agent)
                                                                <option value="{{ $agent->id }}"
                                                                    {{ old('agent_id') === $agent->id ? 'selected' : '' }}>
                                                                    {{ $agent->nama_agen }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('agent_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="toko-cabang-id" class="form-label">
                                                            Toko Cabang
                                                        </label>
                                                        <select id="select-toko_cabangs"
                                                            class="select-data form-select choice" style="cursor:pointer;"
                                                            name="toko_cabang_id" id="toko-cabang-id"
                                                            data-placeholder="-- Pilih Toko Cabang --"
                                                            data-check-selected="false" required>
                                                            @foreach ($toko_cabangs as $toko_cabang)
                                                                <option value="{{ $toko_cabang->id }}"
                                                                    {{ old('toko_cabang_id') === $toko_cabang->id ? 'selected' : '' }}>
                                                                    {{ $toko_cabang->nama_toko_cabang }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('toko_cabang_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="jumlah-transaksi" class="form-label">
                                                            Jumlah Transaksi
                                                        </label>
                                                        <input type="number" min="1" id="jumlah-transaksi"
                                                            value="{{ @old('jumlah_transaksi') }}"
                                                            class="form-control {{ $errors->has('jumlah_transaksi') ? 'is-invalid' : '' }}"
                                                            placeholder="Jumlah Transaksi" name="jumlah_transaksi" required>
                                                    </div>
                                                    @error('jumlah_transaksi')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
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

    @vite('resources/js/choices.js')
    @include('components.ui.loading.button')
@endsection
