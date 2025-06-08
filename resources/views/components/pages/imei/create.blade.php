@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('build/assets/telInput-D9_xf1bf.css') }}">
@endpush

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <div class="gap-2 d-flex justify-content-between justify-content-sm-end">
                <a href="{{ route('master-data.pelanggan.create') }}"
                    class="btn btn-success btn-sm d-inline-flex justify-content-center">
                    <i class="bi bi-plus-circle" style="margin: -2px 2px 0 0; font-size: 15px;"></i>
                    <span>Tambah Pelanggan</span>
                </a>

                <a href="{{ route('jasa-imei.index') }}"
                    class="btn btn-secondary btn-sm d-inline-flex justify-content-center">
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
                                                        <select name="tipe" id="tipe" style="cursor: pointer;"
                                                            class="form-select {{ $errors->has('tipe') ? 'is-invalid' : '' }}"
                                                            required>
                                                            <option>-- Pilih Tipe --</option>
                                                            <option value="slow"
                                                                {{ old('tipe') === 'slow' ? 'selected' : '' }}>
                                                                Slow
                                                            </option>
                                                            <option value="fast"
                                                                {{ old('tipe') === 'fast' ? 'selected' : '' }}>
                                                                Fast
                                                            </option>
                                                        </select>

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
                                                    <div class="form-group mandatory">
                                                        <label for="select-status" class="form-label">
                                                            Status
                                                        </label>
                                                        <select id="status"
                                                            class="form-select @error('status') is-invalid @enderror"
                                                            name="status" style="cursor:pointer;" required>
                                                            <option>-- Pilih Status --</option>
                                                            <option value="proses"
                                                                {{ old('status', isset($data) ? $data->status : '') == 'proses' ? 'selected' : '' }}>
                                                                Proses
                                                            </option>
                                                            <option value="belum_lunas"
                                                                {{ old('status', isset($data) ? $data->status : '') == 'belum_lunas' ? 'selected' : '' }}>
                                                                Belum Lunas
                                                            </option>
                                                            <option value="selesai"
                                                                {{ old('status', isset($data) ? $data->status : '') == 'selesai' ? 'selected' : '' }}>
                                                                Selesai
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small class="text-mute d-none" id="status-message">
                                                        <span class="text-danger">*</span>
                                                        Tidak bisa memilih status "Selesai" jika
                                                        <span class="text-danger">Sisa Server</span> tidak 0
                                                        atau DP Server belum lunas.
                                                    </small>
                                                    @error('status')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
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

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="keterangan" class="form-label">
                                                            Keterangan
                                                        </label>
                                                        <textarea id="keterangan" name="keterangan" rows="6"
                                                            class="form-control w-full rounded {{ $errors->has('keterangan') ? 'border-red-500' : 'border-gray-300' }}"
                                                            placeholder="Isi keterangan (jika perlu)">{{ old('keterangan') }}</textarea>
                                                        @error('keterangan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
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
                                        <h4 class="card-title">Detail Harga</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="modal" class="form-label">Modal</label>
                                                        <input type="text" id="modal" value="{{ @old('modal') }}"
                                                            class="form-control {{ $errors->has('modal') ? 'is-invalid' : '' }}"
                                                            placeholder="Harga Modal" name="modal" required>
                                                        @error('modal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="dp_server" class="form-label">DP Server</label>
                                                        <input type="text" id="dp-server"
                                                            value="{{ @old('dp_server') }}"
                                                            class="form-control {{ $errors->has('dp_server') ? 'is-invalid' : '' }}"
                                                            placeholder="DP Server" name="dp_server" required>
                                                        @error('dp_server')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="sisa_server" class="form-label">Sisa Server</label>
                                                        <input type="text" id="sisa-server"
                                                            value="{{ @old('sisa_server') }}" readonly
                                                            class="form-control {{ $errors->has('sisa_server') ? 'is-invalid' : '' }}"
                                                            placeholder="Sisa Server" name="sisa_server">
                                                        <small class="text-danger d-none" id="sisa-server-message">
                                                            Status Transaksi Belum Lunas
                                                        </small>

                                                        @error('sisa_server')
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
    <script type="module" src="{{ asset('build/assets/calculate2-BtYRnwgA.js') }}"></script>
    <script type="module" src="{{ asset('build/assets/telInput-qKZFCzb-.js') }}"></script>

    @include('components.ui.loading.button')
@endpush
