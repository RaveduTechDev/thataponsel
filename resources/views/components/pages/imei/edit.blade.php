@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <a href="{{ route('jasa-imei.index') }}" class="btn btn-secondary btn-md">
                <span>Kembali</span>
            </a>
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
                                                <div class="col-md-4 col-12">
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

                                                <div class="col-md-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="supplier" class="form-label">Supplier</label>
                                                        <input type="text" id="supplier" class="form-control"
                                                            name="supplier" value="{{ $jasa_imei->supplier }}" required>
                                                    </div>
                                                    @error('supplier')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-agent" class="form-label">Sales/Agent</label>
                                                        <select id="select-agent" class="form-select" name="agent_id"
                                                            required>
                                                            @foreach ($agents as $agent)
                                                                <option value="{{ $agent->id }}"
                                                                    {{ $jasa_imei->agent_id == $agent->id ? 'selected' : '' }}>
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
                                                        id="submitBtn">Update</button>
                                                    <button type="reset"
                                                        class="btn btn-light-secondary me-1 mb-1">Reset</button>
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
