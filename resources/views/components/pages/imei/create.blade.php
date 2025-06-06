@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <a href={{ route('jasa-imei.index') }} style="margin:-8px 0 0 0;"
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
                    <form action={{ route('jasa-imei.store') }} method="POST" enctype="multipart/form-data" class="form"
                        id="formSubmit">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Data Jasa IMEI</h5>
                                        <li>Kolom yang ditandai dengan <span class="text-danger">*</span> wajib diisi.</li>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-pelanggans" class="form-label">
                                                            Pelanggan
                                                        </label>
                                                        <select id="select-pelanggans"
                                                            class="select-data form-select choice" style="cursor:pointer;"
                                                            name="pelanggan_id" data-placeholder="-- Pilih Pelanggan --"
                                                            {{ old('pelanggan_id') ? 'data-check-selected=true' : 'data-check-selected=false' }}>
                                                            @foreach ($pelanggans as $pelanggan)
                                                                <option value="{{ $pelanggan->id }}"
                                                                    {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                                                    {{ $pelanggan->nama_pelanggan }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('pelanggan_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                @if (!Auth::user()->hasRole('agen'))
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group mandatory">
                                                            <label for="select-agent" class="form-label">
                                                                Sales/Agent
                                                            </label>
                                                            <select id="select-agent"
                                                                class="select-data form-select choice {{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                                                                style="cursor:pointer;" name="user_id"
                                                                data-placeholder="-- Pilih Sales/Agent --"
                                                                {{ old('user_id') ? 'data-check-selected=true' : 'data-check-selected=false' }}>
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}"
                                                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                                        {{ $user->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('user_id')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                @endif

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="imei" class="form-label">IMEI</label>
                                                        <input type="text" id="imei"
                                                            class="form-control {{ $errors->has('imei') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('imei') }}" placeholder="IMEI" name="imei">
                                                        @error('imei')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="tipe" class="form-label">Tipe</label>
                                                        <input type="text" id="tipe"
                                                            class="form-control {{ $errors->has('tipe') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('tipe') }}" placeholder="Tipe" name="tipe">
                                                        @error('tipe')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
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
                                                    <div class="form-group mandatory">
                                                        <label for="tanggal" class="form-label">Tanggal</label>
                                                        <input type="date" id="tanggal"
                                                            class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                                                            value="{{ @old('tanggal') }}" placeholder="Tanggal"
                                                            name="tanggal" required>
                                                        @error('tanggal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-status" class="form-label">
                                                            Status
                                                        </label>
                                                        <select id="select-status"
                                                            class="form-select @error('status') is-invalid @enderror"
                                                            name="status" style="cursor:pointer;" required>
                                                            <option>-- Pilih Status --</option>
                                                            <option value="proses"
                                                                {{ old('status', isset($data) ? $data->status : '') == 'proses' ? 'selected' : '' }}>
                                                                Proses
                                                            </option>
                                                            <option value="selesai"
                                                                {{ old('status', isset($data) ? $data->status : '') == 'selesai' ? 'selected' : '' }}>
                                                                Selesai
                                                            </option>
                                                        </select>
                                                    </div>
                                                    @error('status')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Detail IMEI</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="modal" class="form-label">Modal</label>
                                                        <input type="text" id="modal" value="{{ @old('modal') }}"
                                                            class="form-control {{ $errors->has('modal') ? 'is-invalid' : '' }}"
                                                            placeholder="Harga" name="modal" required>
                                                        @error('modal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="biaya" class="form-label">Biaya Jasa</label>
                                                        <input type="text" id="biaya" value="{{ @old('biaya') }}"
                                                            class="form-control {{ $errors->has('biaya') ? 'is-invalid' : '' }}"
                                                            placeholder="Rp. 0" name="biaya" required>
                                                        @error('biaya')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="profit" class="form-label">Profit</label>
                                                        <input type="text" id="profit"
                                                            value="{{ @old('profit') }}" readonly
                                                            class="form-control {{ $errors->has('profit') ? 'is-invalid' : '' }}"
                                                            placeholder="Harga Jual" name="profit" required>
                                                        @error('profit')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="metode-pembayaran" class="form-label">
                                                            Metode Pembayaran
                                                        </label>
                                                        <select name="metode_pembayaran" id="metode-pembayaran"
                                                            style="cursor:pointer" required
                                                            class="form-select {{ $errors->has('metode_pembayaran') ? 'is-invalid' : '' }}">
                                                            <option>-- Pilih Metode Pembayaran--</option>
                                                            <option value="tunai"
                                                                {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>
                                                                Tunai
                                                            </option>
                                                            <option value="transfer"
                                                                {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>
                                                                Transfer
                                                            </option>
                                                            <option value="qris"
                                                                {{ old('metode_pembayaran') == 'qris' ? 'selected' : '' }}>
                                                                QRIS
                                                            </option>
                                                            <option value="e-wallet"
                                                                {{ old('metode_pembayaran') == 'e-wallet' ? 'selected' : '' }}>
                                                                E-Wallet
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
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
    {{-- @vite(['resources/js/choices.js', 'resources/js/calculate2.js']) --}}
    <script type="module" src="{{ asset('build/assets/choices-HcjBDTwy.js') }}"></script>
    <script type="module" src="{{ asset('build/assets/calculate2-CM0A94sm.js') }}"></script>

    @include('components.ui.loading.button')
@endpush
