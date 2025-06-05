@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <div class="gap-2 d-flex justify-content-between justify-content-sm-end">
                @if (!Auth::user()->hasRole('agen'))
                    <button type="button" class="btn btn-danger btn-sm d-inline-flex justify-content-center w-100"
                        data-bs-toggle="modal" data-bs-target="#modalPenjualanDelete">
                        <i class="bi bi-trash" style="margin: -2px 2px 0 0; font-size: 15px;"></i>
                        <span>Hapus</span>
                    </button>
                    <div class="modal fade text-left modal-borderless" id="modalPenjualanDelete" tabindex="-1"
                        aria-labelledby="modalPenjualanLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"
                            style="z-index: 30;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="modalPenjualanLabel">
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
                                    <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST"
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
                <a href="{{ route('penjualan.index') }}" role="button"
                    class="btn btn-secondary btn-sm d-inline-flex justify-content-center w-100">
                    <span>Kembali</span>
                </a>
            </div>
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
                    <form action={{ route('penjualan.update', $penjualan->id) }} method="POST" class="form"
                        id="formSubmit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Data Penjualan</h4>
                                        <li>Kolom yang ditandai dengan <span class="text-danger">*</span> wajib diisi.</li>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="invoice" class="form-label">
                                                            No. Invoice
                                                        </label>
                                                        <input type="text" id="invoice" readonly
                                                            class="form-control {{ $errors->has('invoice') ? 'is-invalid' : '' }}"
                                                            placeholder="No. Invoice" name="invoice"
                                                            value="{{ $penjualan->invoice }}" required>
                                                        @error('invoice')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-agent" class="form-label">
                                                            Sales/Agent
                                                        </label>

                                                        @if ($penjualan->status !== 'selesai')
                                                            <select id="select-agent" class="select-data form-select choice"
                                                                style="cursor:pointer;" name="user_id"
                                                                data-placeholder="-- Pilih Sales/Agent --"
                                                                data-check-selected="true" required>
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}"
                                                                        {{ $penjualan->user_id === $user->id ? 'selected' : '' }}>
                                                                        {{ $user->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <input type="text" value="{{ $penjualan->user->name }}"
                                                                class="form-control" id="agent" readonly>
                                                        @endif
                                                    </div>
                                                    @error('user_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-toko_cabangs" class="form-label">
                                                            Toko Cabang
                                                        </label>

                                                        @if ($penjualan->status !== 'selesai')
                                                            <select id="select-toko_cabangs"
                                                                class="select-data form-select choice"
                                                                style="cursor:pointer;" name="toko_cabang_id"
                                                                data-placeholder="-- Pilih Toko Cabang --"
                                                                data-check-selected="true" required>
                                                                @foreach ($toko_cabangs as $toko_cabang)
                                                                    <option value="{{ $toko_cabang->id }}"
                                                                        {{ $penjualan->toko_cabang_id === $toko_cabang->id ? 'selected' : '' }}>
                                                                        {{ $toko_cabang->nama_toko_cabang }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <input type="text"
                                                                value="{{ $penjualan->tokoCabang->nama_toko_cabang }}"
                                                                class="form-control" id="toko_cabang_name" readonly>
                                                        @endif
                                                    </div>

                                                    @error('toko_cabang_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-pelanggans" class="form-label">
                                                            Pelanggan
                                                        </label>
                                                        @if ($penjualan->status !== 'selesai')
                                                            <select id="select-pelanggans"
                                                                class="select-data form-select choice"
                                                                style="cursor:pointer;" name="pelanggan_id"
                                                                data-placeholder="-- Pilih Pelanggan --"
                                                                data-check-selected="true" required>
                                                                @foreach ($pelanggans as $pelanggan)
                                                                    <option value="{{ $pelanggan->id }}"
                                                                        {{ $penjualan->pelanggan_id === $pelanggan->id ? 'selected' : '' }}>
                                                                        {{ $pelanggan->nama_pelanggan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <input type="text"
                                                                value="{{ $penjualan->pelanggan->nama_pelanggan }}"
                                                                class="form-control" id="pelanggan_name" readonly>
                                                        @endif
                                                    </div>
                                                    @error('pelanggan_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-barang" class="form-label">
                                                            Barang
                                                        </label>

                                                        @if ($penjualan->status !== 'selesai')
                                                            <select id="select-barang"
                                                                class="select-data form-select choice"
                                                                style="cursor:pointer;" name="stock_id"
                                                                data-placeholder="-- Pilih Toko Cabang --"
                                                                data-check-selected="true" data-calc="true"
                                                                data-init="true" required>
                                                                @foreach ($stocks as $stock)
                                                                    <option value="{{ $stock->id }}"
                                                                        data-price="{{ $stock->harga_jual }}"
                                                                        {{ $penjualan->stock_id === $stock->id ? 'selected' : '' }}>
                                                                        {{ $stock->barang->merk }} -
                                                                        {{ $stock->barang->nama_barang }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <input type="text"
                                                                value="{{ $penjualan->stock->barang->merk }} - {{ $penjualan->stock->barang->nama_barang }}"
                                                                class="form-control" id="barang_name" readonly>
                                                        @endif
                                                    </div>
                                                    @error('stock_id"')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="qty" class="form-label">
                                                            QTY (Jumlah Barang)
                                                        </label>

                                                        @if ($penjualan->status !== 'selesai')
                                                            <input type="number" id="qty"
                                                                class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}"
                                                                placeholder="QTY" name="qty" min="1"
                                                                value="{{ $penjualan->qty }}" required>
                                                        @else
                                                            <input type="text" id="qty" class="form-control"
                                                                placeholder="QTY" value="{{ $penjualan->qty }}" readonly>
                                                        @endif

                                                        @error('qty')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-status" class="form-label">
                                                            Status
                                                        </label>
                                                        @if ($penjualan->status == 'selesai')
                                                            <div>
                                                                <div class="badge text-bg-success ">Selesai</div>
                                                            </div>
                                                        @else
                                                            <select id="select-status" class="form-select" name="status"
                                                                style="cursor:pointer;" required>
                                                                <option value="selesai"
                                                                    {{ $penjualan->status == 'selesai' ? 'selected' : '' }}>
                                                                    Selesai
                                                                </option>
                                                                <option value="proses"
                                                                    {{ $penjualan->status == 'proses' ? 'selected' : '' }}>
                                                                    Proses
                                                                </option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                    @error('status')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="tanggal" class="form-label">
                                                            Tanggal Transaksi
                                                        </label>

                                                        @if ($penjualan->status !== 'selesai')
                                                            <input type="date" id="tanggal_transaksi"
                                                                class="form-control {{ $errors->has('tanggal_transaksi') ? 'is-invalid' : '' }}"
                                                                placeholder="Tanggal Transaksi" name="tanggal_transaksi"
                                                                value="{{ $penjualan->tanggal_transaksi }}" required>
                                                        @else
                                                            <input type="text" id="tanggal_transaksi"
                                                                class="form-control" placeholder="Tanggal Transaksi"
                                                                value="{{ $penjualan->tanggal_transaksi }}" readonly>
                                                        @endif

                                                        @error('tanggal_transaksi')
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
                                        <h5 class="text-secondary">Detail Penjualan</h5>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="sub-total" class="form-label">
                                                            Sub Total
                                                        </label>
                                                        <input type="text" id="sub-total" min="0" readonly
                                                            class="form-control {{ $errors->has('subtotal') ? 'is-invalid' : '' }}"
                                                            placeholder="Sub Total" name="subtotal"
                                                            value="{{ $penjualan->subtotal }}" required>
                                                        @error('subtotal')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="diskon" class="form-label">
                                                            Diskon (%)
                                                        </label>
                                                        @if ($penjualan->status !== 'selesai')
                                                            <input
                                                                class="form-control {{ $errors->has('diskon') ? 'is-invalid' : '' }}"
                                                                type="number" id="diskon"
                                                                value="{{ $penjualan->diskon }}" min="0"
                                                                max="100" placeholder="Diskon" name="diskon">
                                                        @else
                                                            <input type="text" value="{{ $penjualan->diskon }}%"
                                                                class="form-control" id="diskon" readonly>
                                                        @endif
                                                        @error('diskon')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="total-bayar" class="form-label">
                                                            Total Bayar
                                                        </label>
                                                        <input type="text" id="total-bayar" readonly
                                                            class="form-control {{ $errors->has('total_bayar') ? 'is-invalid' : '' }}"
                                                            placeholder="Total Bayar" name="total_bayar" min="0"
                                                            value="{{ $penjualan->total_bayar }}" data-check-value="true"
                                                            required>
                                                        @error('total_bayar')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group madatory">
                                                        <label for="metode-pembayaran" class="form-label">
                                                            Metode Pembayaran
                                                        </label>
                                                        @if ($penjualan->status !== 'selesai')
                                                            <select name="metode_pembayaran" id="metode-pembayaran"
                                                                style="cursor:pointer"
                                                                class="form-select {{ $errors->has('metode_pembayaran') ? 'is-invalid' : '' }}">
                                                                <option>-- Pilih Metode Pembayaran--</option>
                                                                <option value="tunai"
                                                                    {{ $penjualan->metode_pembayaran == 'tunai' ? 'selected' : '' }}>
                                                                    Tunai
                                                                </option>
                                                                <option value="transfer"
                                                                    {{ $penjualan->metode_pembayaran == 'transfer' ? 'selected' : '' }}>
                                                                    Transfer
                                                                </option>
                                                                <option value="qris"
                                                                    {{ $penjualan->metode_pembayaran == 'qris' ? 'selected' : '' }}>
                                                                    QRIS
                                                                </option>
                                                                <option value="e-wallet"
                                                                    {{ $penjualan->metode_pembayaran == 'e-wallet' ? 'selected' : '' }}>
                                                                    E-Wallet
                                                                </option>
                                                            </select>
                                                        @else
                                                            <input type="text"
                                                                value="{{ $penjualan->metode_pembayaran }}"
                                                                class="form-control" id="metode_pembayaran" readonly>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($penjualan->status !== 'selesai')
                                                <div class="row mt-1">
                                                    <div class="col-12 d-flex justify-content-start">
                                                        <button type="submit" class="btn btn-primary me-3 mb-1"
                                                            id="submitBtn">
                                                            Edit
                                                        </button>
                                                    </div>
                                                </div>
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
    {{-- @vite(['resources/js/choices.js', 'resources/js/calculate.js']) --}}
    <script type="module" src="{{ asset('build/assets/choices-BGT1ZLBO.js') }}"></script>
    <script type="module" src="{{ asset('build/assets/calculate-BzQbymq7.js') }}"></script>
    @include('components.ui.loading.button')
@endpush
