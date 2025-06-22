@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('build/assets/telInput-D9_xf1bf.css') }}">
@endpush

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

        @if ($jasa_imei->status === 'selesai')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Perhatian!</strong> Data yang sudah selesai tidak dapat diubah lagi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                                                        @if ($jasa_imei->status === 'selesai')
                                                            <input type="text" id="select-pelanggans"
                                                                class="form-control"
                                                                value="{{ $jasa_imei->pelanggan->nama_pelanggan }}"
                                                                placeholder="Pelanggan" readonly>
                                                        @else
                                                            <select id="select-pelanggans"
                                                                class="select-data form-select choice"
                                                                style="cursor:pointer;" name="pelanggan_id"
                                                                data-placeholder="-- Pilih Pelanggan --"
                                                                data-check-selected="true">
                                                                @foreach ($pelanggans as $pelanggan)
                                                                    <option value="{{ $pelanggan->id }}"
                                                                        {{ $jasa_imei->pelanggan_id === $pelanggan->id ? 'selected' : '' }}>
                                                                        {{ $pelanggan->nama_pelanggan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if (!Auth::user()->hasRole('admin'))
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group mandatory">
                                                            <label for="select-agent" class="form-label">
                                                                Sales/Agent
                                                            </label>

                                                            @if ($jasa_imei->status === 'selesai')
                                                                <input type="text" id="select-agent"
                                                                    class="form-control"
                                                                    value="{{ $jasa_imei->user->name }}"
                                                                    placeholder="Sales/Agent" readonly>
                                                            @else
                                                                <select id="select-agent"
                                                                    class="select-data form-select choice"
                                                                    style="cursor:pointer;" name="user_id"
                                                                    data-placeholder="-- Pilih Sales/Agent --"
                                                                    data-check-selected="true">
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}"
                                                                            {{ $jasa_imei->user_id === $user->id ? 'selected' : '' }}>
                                                                            {{ $user->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @endif

                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="imei" class="form-label">IMEI</label>

                                                        @if ($jasa_imei->status === 'selesai')
                                                            <input type="text" id="imei" class="form-control"
                                                                value="{{ $jasa_imei->imei }}" placeholder="IMEI"
                                                                readonly>
                                                        @else
                                                            <input type="text" id="imei"
                                                                class="form-control number-format {{ $errors->has('imei') ? 'is-invalid' : '' }}"
                                                                value="{{ old('imei', $jasa_imei->imei) }}"
                                                                placeholder="IMEI" name="imei">
                                                        @endif
                                                        <small class="text-danger error-number-format"></small>

                                                        @error('imei')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="tipe" class="form-label">Tipe</label>

                                                        @if ($jasa_imei->status === 'selesai')
                                                            <input type="text" id="tipe" class="form-control"
                                                                value="{{ $jasa_imei->tipe }}" placeholder="Tipe"
                                                                readonly>
                                                        @else
                                                            <select name="tipe" id="tipe"
                                                                style="cursor: pointer;"
                                                                class="form-select {{ $errors->has('tipe') ? 'is-invalid' : '' }}"
                                                                required>
                                                                <option>-- Pilih Tipe --</option>
                                                                <option value="slow"
                                                                    {{ old('tipe', $jasa_imei->tipe) === 'slow' ? 'selected' : '' }}>
                                                                    Slow
                                                                </option>
                                                                <option value="fast"
                                                                    {{ old('tipe', $jasa_imei->tipe) === 'fast' ? 'selected' : '' }}>
                                                                    Fast
                                                                </option>
                                                            </select>
                                                        @endif

                                                        @error('tipe')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="supplier" class="form-label">Supplier</label>

                                                        @if ($jasa_imei->status === 'selesai')
                                                            <input type="text" id="supplier" class="form-control"
                                                                value="{{ $jasa_imei->supplier }}" placeholder="Supplier"
                                                                readonly>
                                                        @else
                                                            <input type="text" id="supplier"
                                                                class="form-control {{ $errors->has('supplier') ? 'is-invalid' : '' }}"
                                                                value="{{ old('supplier', $jasa_imei->supplier) }}"
                                                                placeholder="Supplier" name="supplier" required>
                                                        @endif

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
                                                        @if ($jasa_imei->status === 'selesai')
                                                            <input type="text" id="no_kontak_supplier"
                                                                class="form-control"
                                                                value="{{ $jasa_imei->no_kontak_supplier }}"
                                                                placeholder="No Kontak Supplier" readonly>
                                                        @else
                                                            <input id="phone" type="tel"
                                                                value="{{ old('no_kontak_supplier', $jasa_imei->no_kontak_supplier) }}"
                                                                class="form-control {{ $errors->has('no_kontak_supplier') ? 'is-invalid' : '' }}"
                                                                name="no_kontak_supplier">
                                                        @endif
                                                    </div>
                                                    @error('no_kontak_supplier')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-status" class="form-label">
                                                            Status
                                                        </label>

                                                        @if ($jasa_imei->status === 'selesai')
                                                            <div>
                                                                <div class="badge text-bg-success ">Selesai</div>
                                                            </div>
                                                        @else
                                                            <select id="status" class="form-select" name="status"
                                                                style="cursor:pointer;" required>
                                                                <option value="proses"
                                                                    {{ old('status', $jasa_imei->status) === 'proses' ? 'selected' : '' }}>
                                                                    Proses
                                                                </option>
                                                                <option value="belum_lunas"
                                                                    {{ old('status', $jasa_imei->status) === 'belum_lunas' ? 'selected' : '' }}>
                                                                    Belum Lunas
                                                                </option>
                                                                <option value="selesai"
                                                                    {{ old('status', $jasa_imei->status) === 'selesai' ? 'selected' : '' }}>
                                                                    Selesai
                                                                </option>
                                                            </select>
                                                            <small class="text-mute d-none" id="status-message">
                                                                <span class="text-danger">*</span>
                                                                Tidak bisa memilih status "Selesai" jika
                                                                <span class="text-danger">Sisa Server</span> tidak 0
                                                                atau DP Server belum lunas.
                                                            </small>
                                                        @endif

                                                        @error('status')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="tanggal" class="form-label">Tanggal</label>

                                                        @if ($jasa_imei->status === 'selesai')
                                                            <input type="text" id="tanggal" class="form-control"
                                                                value="{{ \Carbon\Carbon::parse($jasa_imei->tanggal)->isoFormat('D-MMMM-Y') }}"
                                                                placeholder="Tanggal" readonly>
                                                        @else
                                                            <input type="date" id="tanggal"
                                                                class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                                                                value="{{ old('tanggal', $jasa_imei->tanggal) }}"
                                                                placeholder="Tanggal" name="tanggal" required>
                                                        @endif

                                                        @error('tanggal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="keterangan" class="form-label">
                                                        Keterangan
                                                    </label>
                                                    <textarea id="keterangan" name="keterangan" rows="6"
                                                        class="form-control w-full rounded {{ $errors->has('keterangan') ? 'border-red-500' : 'border-gray-300' }}"
                                                        placeholder="Isi keterangan (jika perlu)">{{ old('keterangan', $jasa_imei->keterangan) }}</textarea>
                                                    @error('keterangan')
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
                                        <h4 class="card-title">Detail Harga</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="modal" class="form-label">Modal</label>
                                                        @if ($jasa_imei->status === 'selesai')
                                                            <input type="text" id="modal" class="form-control"
                                                                value="{{ $jasa_imei->modal }}" placeholder="Modal"
                                                                readonly>
                                                        @else
                                                            <input type="text" id="modal"
                                                                value="{{ old('modal', $jasa_imei->modal) }}"
                                                                class="form-control {{ $errors->has('modal') ? 'is-invalid' : '' }}"
                                                                placeholder="Harga Modal" name="modal" required>
                                                        @endif

                                                        @error('modal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="dp_server" class="form-label">DP Server</label>
                                                        <input type="text" id="dp-server"
                                                            value="{{ @old('dp_server', $jasa_imei->dp_server) }}"
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
                                                            value="{{ @old('sisa_server', $jasa_imei->sisa_server) }}"
                                                            readonly
                                                            class="form-control {{ $errors->has('sisa_server') ? 'is-invalid' : '' }}"
                                                            placeholder="Sisa Server" name="sisa_server">
                                                        @error('sisa_server')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="biaya" class="form-label">Biaya Jasa</label>

                                                        @if ($jasa_imei->status === 'selesai')
                                                            <input type="text" id="biaya" class="form-control"
                                                                value="{{ $jasa_imei->biaya }}" placeholder="Biaya Jasa"
                                                                readonly>
                                                        @else
                                                            <input type="text" id="biaya"
                                                                value="{{ old('biaya', $jasa_imei->biaya) }}"
                                                                class="form-control {{ $errors->has('biaya') ? 'is-invalid' : '' }}"
                                                                placeholder="Rp. 0" name="biaya" required>
                                                        @endif

                                                        @error('biaya')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="profit" class="form-label">Profit</label>
                                                        @if ($jasa_imei->status === 'selesai')
                                                            <input type="text" id="profit" class="form-control"
                                                                value="{{ $jasa_imei->profit }}" placeholder="Profit"
                                                                readonly>
                                                        @else
                                                            <input type="text" id="profit"
                                                                value="{{ old('profit', $jasa_imei->profit) }}" readonly
                                                                class="form-control {{ $errors->has('profit') ? 'is-invalid' : '' }}"
                                                                placeholder="Harga Jual" name="profit" required>
                                                        @endif
                                                        @error('profit')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group madatory">
                                                        <label for="metode-pembayaran" class="form-label">
                                                            Metode Pembayaran
                                                        </label>
                                                        @if ($jasa_imei->status === 'selesai')
                                                            <input type="text" id="metode-pembayaran"
                                                                class="form-control"
                                                                value="{{ $jasa_imei->metode_pembayaran }}"
                                                                placeholder="Metode Pembayaran" name="metode_pembayaran"
                                                                readonly>
                                                        @else
                                                            <select name="metode_pembayaran" id="metode-pembayaran"
                                                                style="cursor:pointer"
                                                                class="form-select {{ $errors->has('metode_pembayaran') ? 'is-invalid' : '' }}">
                                                                <option>-- Pilih Metode Pembayaran--</option>
                                                                <option value="tunai"
                                                                    {{ $jasa_imei->metode_pembayaran == 'tunai' ? 'selected' : '' }}>
                                                                    Tunai
                                                                </option>
                                                                <option value="transfer"
                                                                    {{ $jasa_imei->metode_pembayaran == 'transfer' ? 'selected' : '' }}>
                                                                    Transfer
                                                                </option>
                                                                <option value="qris"
                                                                    {{ $jasa_imei->metode_pembayaran == 'qris' ? 'selected' : '' }}>
                                                                    QRIS
                                                                </option>
                                                                <option value="e-wallet"
                                                                    {{ $jasa_imei->metode_pembayaran == 'e-wallet' ? 'selected' : '' }}>
                                                                    E-Wallet
                                                                </option>
                                                            </select>
                                                        @endif
                                                        @error('metode_pembayaran')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($jasa_imei->status !== 'selesai')
                                                @if (!Auth::user()->hasRole('owner'))
                                                    <div class="row mt-2">
                                                        <div class="col-12 d-flex justify-content-start">
                                                            <button type="submit" class="btn btn-primary me-3 mb-1"
                                                                id="submitBtn">
                                                                Ubah
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
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
@endpush
