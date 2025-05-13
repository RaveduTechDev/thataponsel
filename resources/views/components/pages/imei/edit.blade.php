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
                                    <form action="{{ route('jasa-imei.destroy', $jasa_imei->id) }}" method="POST"
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
                <a href="{{ route('jasa-imei.index') }}"
                    class="btn btn-secondary btn-sm d-inline-flex justify-content-center w-100">
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <section id="multiple-column-form">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row match-height">
                <div class="col-12">
                    <form action="{{ route('jasa-imei.update', $jasa_imei->id) }}" method="POST" id="formSubmit"
                        class="form">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div
                                                    class="{{ Auth::user()->hasRole('agen') ? 'col-md-6' : 'col-md-4' }} col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-pelanggans" class="form-label">Pelanggan</label>
                                                        <select id="select-pelanggans" class="form-select"
                                                            name="pelanggan_id" required>
                                                            @foreach ($pelanggans as $pelanggan)
                                                                <option value="{{ $pelanggan->id }}"
                                                                    {{ $jasa_imei->pelanggan_id == $pelanggan->id ? 'selected' : '' }}>
                                                                    {{ $pelanggan->nama_pelanggan }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('pelanggan_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div
                                                    class="{{ Auth::user()->hasRole('agen') ? 'col-md-6' : 'col-md-4' }} col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="supplier" class="form-label">Supplier</label>
                                                        <input type="text" id="supplier" class="form-control"
                                                            name="supplier" value="{{ $jasa_imei->supplier }}" required>
                                                    </div>
                                                    @error('supplier')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                @if (!Auth::user()->hasRole('agen'))
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-group mandatory">
                                                            <label for="select-agent" class="form-label">Sales/Agent</label>
                                                            <select id="select-agent"
                                                                class="select-data form-select choice {{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                                                                style="cursor:pointer;" name="user_id"
                                                                data-placeholder="-- Pilih Sales/Agent --" name="user_id"
                                                                data-check-selected="true" required>
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}"
                                                                        {{ $jasa_imei->user_id == $user->id ? 'selected' : '' }}>
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
                                                    <div class="form-group">
                                                        <label for="tipe" class="form-label">Tipe</label>
                                                        <input type="text" id="tipe" class="form-control"
                                                            name="tipe" value="{{ $jasa_imei->tipe }}" required>
                                                    </div>
                                                    @error('tipe')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="imei" class="form-label">IMEI</label>
                                                        <input type="text" id="imei" class="form-control"
                                                            name="imei" value="{{ $jasa_imei->imei }}" readonly
                                                            required>
                                                    </div>
                                                    @error('imei')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="biaya" class="form-label">Biaya</label>
                                                        <input type="text" id="biaya" class="form-control"
                                                            name="biaya" value="{{ $jasa_imei->biaya }}" required>
                                                    </div>
                                                    @error('biaya')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="modal" class="form-label">Modal</label>
                                                        <input type="text" id="modal" class="form-control"
                                                            name="modal" value="{{ $jasa_imei->modal }}" required>
                                                    </div>
                                                    @error('modal')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="profit" class="form-label">Profit</label>
                                                        <input type="text" id="profit" class="form-control"
                                                            name="profit" value="{{ $jasa_imei->profit }}" required>
                                                    </div>
                                                    @error('profit')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-status" class="form-label">Status</label>
                                                        <select id="select-status"
                                                            class="select-status form-select choices multiple-remove"
                                                            name="status" data-check-selected="true" multiple required>
                                                            <option value="proses"
                                                                {{ $jasa_imei->status == 'proses' ? 'selected' : '' }}>
                                                                Proses
                                                            </option>
                                                            <option value="selesai"
                                                                {{ $jasa_imei->status == 'selesai' ? 'selected' : '' }}>
                                                                Selesai
                                                            </option>
                                                        </select>
                                                    </div>
                                                    @error('status')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary me-3 mb-1"
                                                        id="submitBtn">
                                                        Ubah
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
    @vite(['resources/js/choices.js', 'resources/js/calculate2.js'])
    @include('components.ui.loading.button')
@endsection
