@extends('layouts.app')

@section('content')
    <section class="section">
        {{-- search --}}
        <div class="card">
            <div class="card-header mb-3">
                @if (request()->is('rekap'))
                    <h4 class="text-danger">Cari Berdasarkan Tanggal</h4>
                @elseif (request()->is('rekap/agen*'))
                    <h4 class="text-danger">Cari Berdasarkan Agen/Sales</h4>
                @endif
            </div>

            <div class="card-body">
                <form
                    action="@if (request()->is('rekap')) {{ route('rekap') }} @elseif(request()->is('rekap/agen*')) {{ route('rekap.agen') }} @endif"
                    method="GET" id="formSubmit" class="row g-3">
                    <div class="col-12 col-md-6 {{ request()->is('rekap/agen*') ? 'col-lg-2' : 'col-lg-3' }}">
                        <label for="start_date" class="form-label">Mulai Tanggal</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-12 col-md-6 {{ request()->is('rekap/agen*') ? 'col-lg-2' : 'col-lg-3' }}">
                        <label for="end_date" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ request('end_date') }}" />
                    </div>
                    @if (request()->is('rekap/agen*'))
                        <div class="col-12 col-md-6 col-lg-3" style="z-index: 20">
                            <label for="agent_name" class="form-label">Nama Agen</label>
                            <select id="select-agent"
                                class="select-data form-select choice position-relative {{ $errors->has('agent_id') ? 'is-invalid' : '' }}"
                                style="cursor:pointer;" name="search" data-placeholder="-- Pilih Agen --"
                                data-check-selected="{{ request('search') ? 'true' : 'false' }}">
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}"
                                        {{ $displayPerUser === $user->name ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- select category penjualan or imei --}}
                    <div class="col-12 {{ request()->is('rekap/agen*') ? 'col-md-3 col-lg-2' : 'col-md-3' }}">
                        <label for="category" class="form-label">Kategori</label>
                        <select id="category" class="form-select" name="category" style="cursor: pointer;">
                            <option value="" {{ request('category') === null ? 'selected' : '' }}>Semua</option>
                            <option value="penjualan" {{ request('category') === 'penjualan' ? 'selected' : '' }}>Penjualan
                            </option>
                            <option value="imei" {{ request('category') === 'imei' ? 'selected' : '' }}>IMEI</option>
                        </select>
                    </div>

                    <div
                        class="col-12 {{ request()->is('rekap/agen*') ? 'col-md-2' : 'col-md-12' }} col-lg-3 d-flex align-items-end">
                        <button type="submit" id="submitBtn"
                            class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-search me-1" style="margin-top: -12px"></i>
                            <span>Cari</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if (request('category') === 'penjualan')
            <div class="card">
                <div class="card-header">
                    <h3 class="text-danger mb-4">Penjualan HP</h3>
                    <div class="card-header-actions mb-4">
                        <form action="{{ route('rekap.export.penjualan') }}" method="post" target="_blank">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="username" value="{{ request('username') }}">

                            <button type="submit"
                                class="btn btn-success d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-excel" style="margin: -10px 2px 0 0"></i>
                                Export Excel
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if (request('start_date') || request('end_date') || request('search') || request('username'))
                        <table class="mb-4">
                            <tr>
                                <th class="text-nowrap me-lg-2">Mulai Tanggal</th>
                                <td class="text-nowrap">: </td>
                                <td class="text-nowrap">
                                    {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-nowrap me-lg-2">Sampai Tanggal</th>
                                <td class="text-nowrap">: </td>
                                <td class="text-nowrap">
                                    {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            @if (request()->is('rekap/agen*') || request('search') || request('username'))
                                <tr>
                                    <th class="text-nowrap me-lg-2">Nama Agen/Sales</th>
                                    <td class="text-nowrap">:</td>
                                    <td class="text-nowrap">
                                        {{ $displayPerUser }}
                                    </td>
                                </tr>
                            @endif
                        </table>
                    @endif

                    <div class="table-responsive pt-2 pe-2" id="table-container">
                        <div class="dropdown" id="dropdown-columns">
                            <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-funnel"></i>
                                <span class="visually-hidden">Filter</span>
                            </button>
                            <div class="dropdown-menu">
                                <h2 class="dropdown-header fs-5" style="margin: 0 0 -10px -10px">Tampilkan Kolom</h2>
                                <div id="toggle-columns" class="p-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="0"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Invoice</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="1"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Barang</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="2"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Tanggal Transaksi</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="3"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Pelanggan</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="4"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Toko Cabang</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="5"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Agent</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="6"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Sub Total</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="7"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Total Bayar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="loading" style="display: none" class="spinner-border spinner-border-sm text-danger"
                            role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                        <table class="table table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th class="text-nowrap w-xl-50">Invoice</th>
                                    <th class="text-nowrap">Barang</th>
                                    <th class="text-nowrap">Tanggal Transaksi</th>
                                    <th class="text-nowrap">Pelanggan</th>
                                    <th class="text-nowrap">Toko Cabang</th>
                                    <th class="text-nowrap">Agent</th>
                                    <th class="text-nowrap">Sub Total</th>
                                    <th class="text-nowrap">Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualans as $penjualan)
                                    <tr>
                                        <td class="text-nowrap w-xl-50">{{ $penjualan->invoice }}</td>
                                        <td class="text-nowrap ">{{ $penjualan->stock->barang->nama_barang }}</td>
                                        <td class="text-nowrap ">
                                            {{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->isoFormat('D MMMM YY') }}
                                        </td>
                                        <td class="text-nowrap ">{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                                        <td class="text-nowrap ">{{ $penjualan->tokoCabang->nama_toko_cabang }}</td>
                                        <td class="text-nowrap ">
                                            @if (request()->is('rekap/agen*'))
                                                <a href="{{ route('rekap.agen', ['username' => $penjualan->user->username]) }}"
                                                    style="text-decoration: underline;">
                                                    {{ $penjualan->user->name }}
                                                </a>
                                            @else
                                                {{ $penjualan->user->name }}
                                            @endif
                                        </td>
                                        <td class="text-nowrap ">
                                            Rp. {{ number_format($penjualan->subtotal, 0, ',', '.') }}
                                        </td>

                                        <td class="text-nowrap ">
                                            Rp. {{ number_format($penjualan->total_bayar, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="5"></th>
                                    <th class="text-nowrap">Total :</th>
                                    <th class="text-nowrap">
                                        Rp. {{ number_format($penjualans->sum('subtotal'), 0, ',', '.') }}
                                    </th>
                                    <th class="text-nowrap">
                                        Rp. {{ number_format($penjualans->sum('total_bayar'), 0, ',', '.') }}
                                    </th>
                                </tr>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @elseif (request('category') === 'imei')
            <div class="card">
                <div class="card-header">
                    <h3 class="text-danger">Penjualan IMEI</h3>
                    <div class="card-header-actions mb-4">
                        <form action="{{ route('rekap.export.imei') }}" method="post" target="_blank">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="username" value="{{ request('username') }}">

                            <button type="submit"
                                class="btn btn-success d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-excel" style="margin: -10px 2px 0 0"></i>
                                Export Excel
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">

                    {{-- menampilkan data dari get request search  --}}
                    @if (request('start_date') || request('end_date') || request('search') || request('username'))
                        <table class="mb-4">
                            <tr>
                                <th class="text-nowrap me-lg-2">Mulai Tanggal</th>
                                <td class="text-nowrap">: </td>
                                <td class="text-nowrap">
                                    {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-nowrap me-lg-2">Sampai Tanggal</th>
                                <td class="text-nowrap">: </td>
                                <td class="text-nowrap">
                                    {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            @if (request()->is('rekap/agen*') || request('search') || request('username'))
                                <tr>
                                    <th class="text-nowrap me-lg-2">Nama Agen/Sales</th>
                                    <td class="text-nowrap">:</td>
                                    <td class="text-nowrap">
                                        {{ $displayPerUser }}
                                    </td>
                                </tr>
                            @endif
                        </table>
                    @endif

                    <div class="table-responsive pt-2 pe-2" id="table-container">
                        <div class="dropdown" id="dropdown-columns2">
                            <button class="btn btn-danger btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-funnel"></i>
                                <span class="visually-hidden">Filter</span>
                            </button>
                            <div class="dropdown-menu">
                                <h2 class="dropdown-header fs-5" style="margin: 0 0 -10px -10px">Tampilkan Kolom</h2>
                                <div id="toggle-columns-imei" class="p-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="0"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">IMEI</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="1"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Tipe</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="2"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Tanggal Transaksi</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="3"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Pelanggan</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="4"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Agen</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="5"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Biaya</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="6"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Modal</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="7"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Profit</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="loadingImei" style="display: none" class="spinner-border spinner-border-sm text-danger"
                        role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>

                    <table class="table table-striped table-hover" id="tableImei">
                        <thead>
                            <tr>
                                <th class="text-nowrap w-xl-50">IMEI</th>
                                <th class="text-nowrap">Tipe</th>
                                <th class="text-nowrap">Tanggal Transaksi</th>
                                <th class="text-nowrap">Pelanggan</th>
                                <th class="text-nowrap">Agen</th>
                                <th class="text-nowrap">Biaya</th>
                                <th class="text-nowrap">Modal</th>
                                <th class="text-nowrap">Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jasa_imeis as $jasa_imei)
                                <tr>
                                    <td class="text-nowrap w-xl-50">{{ $jasa_imei->imei }}</td>
                                    <td class="text-nowrap">{{ $jasa_imei->tipe }}</td>
                                    <td class="text-nowrap">
                                        {{ \Carbon\Carbon::parse($jasa_imei->tanggal)->isoFormat('D MMMM YY') }}
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $jasa_imei->pelanggan->nama_pelanggan }}
                                    </td>
                                    <td class="text-nowrap">
                                        @if (request()->is('rekap/agen*'))
                                            <a href="{{ route('rekap.agen', ['username' => $jasa_imei->user->username]) }}"
                                                style="text-decoration: underline;">
                                                {{ $jasa_imei->user->name }}
                                            </a>
                                        @else
                                            {{ $jasa_imei->user->name }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        Rp. {{ number_format($jasa_imei->biaya, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap">
                                        Rp. {{ number_format($jasa_imei->modal, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap">
                                        Rp. {{ number_format($jasa_imei->profit, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4"></th>
                                <th class="text-nowrap">Total :</th>
                                <th class="text-nowrap">
                                    Rp. {{ number_format($jasa_imeis->sum('biaya'), 0, ',', '.') }}
                                </th>
                                <th class="text-nowrap">
                                    Rp. {{ number_format($jasa_imeis->sum('modal'), 0, ',', '.') }}
                                </th>
                                <th class="text-nowrap">
                                    Rp. {{ number_format($jasa_imeis->sum('profit'), 0, ',', '.') }}
                                </th>
                            </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
        @else
            {{-- penjualan hp --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="text-danger mb-4">Penjualan HP</h3>
                    <div class="card-header-actions mb-4">
                        <form action="{{ route('rekap.export.penjualan') }}" method="post" target="_blank">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="username" value="{{ request('username') }}">

                            <button type="submit"
                                class="btn btn-success d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-excel" style="margin: -10px 2px 0 0"></i>
                                Export Excel
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if (request('start_date') || request('end_date') || request('search') || request('username'))
                        <table class="mb-4">
                            <tr>
                                <th class="text-nowrap me-lg-2">Mulai Tanggal</th>
                                <td class="text-nowrap">: </td>
                                <td class="text-nowrap">
                                    {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-nowrap me-lg-2">Sampai Tanggal</th>
                                <td class="text-nowrap">: </td>
                                <td class="text-nowrap">
                                    {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            @if (request()->is('rekap/agen*') || request('search') || request('username'))
                                <tr>
                                    <th class="text-nowrap me-lg-2">Nama Agen/Sales</th>
                                    <td class="text-nowrap">:</td>
                                    <td class="text-nowrap">
                                        {{ $displayPerUser }}
                                    </td>
                                </tr>
                            @endif
                        </table>
                    @endif

                    <div class="table-responsive pt-2 pe-2" id="table-container">
                        <div class="dropdown" id="dropdown-columns">
                            <button class="btn btn-danger btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-funnel"></i>
                                <span class="visually-hidden">Filter</span>
                            </button>
                            <div class="dropdown-menu">
                                <h2 class="dropdown-header fs-5" style="margin: 0 0 -10px -10px">Tampilkan Kolom</h2>
                                <div id="toggle-columns" class="p-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="0"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Invoice</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="1"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Barang</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="2"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Tanggal Transaksi</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="3"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Pelanggan</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="4"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Toko Cabang</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="5"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Agent</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="6"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Sub Total</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column="7"
                                            data-name="penjualan_rekap" checked>
                                        <label class="form-check-label">Total Bayar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="loading" style="display: none" class="spinner-border spinner-border-sm text-danger"
                            role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                        <table class="table table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th class="text-nowrap w-xl-50">Invoice</th>
                                    <th class="text-nowrap">Barang</th>
                                    <th class="text-nowrap">Tanggal Transaksi</th>
                                    <th class="text-nowrap">Pelanggan</th>
                                    <th class="text-nowrap">Toko Cabang</th>
                                    <th class="text-nowrap">Agent</th>
                                    <th class="text-nowrap">Sub Total</th>
                                    <th class="text-nowrap">Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualans as $penjualan)
                                    <tr>
                                        <td class="text-nowrap w-xl-50">{{ $penjualan->invoice }}</td>
                                        <td class="text-nowrap ">{{ $penjualan->stock->barang->nama_barang }}</td>
                                        <td class="text-nowrap ">
                                            {{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->isoFormat('D MMMM YY') }}
                                        </td>
                                        <td class="text-nowrap ">{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                                        <td class="text-nowrap ">{{ $penjualan->tokoCabang->nama_toko_cabang }}</td>
                                        <td class="text-nowrap ">
                                            @if (request()->is('rekap/agen*'))
                                                <a href="{{ route('rekap.agen', ['username' => $penjualan->user->username]) }}"
                                                    style="text-decoration: underline;">
                                                    {{ $penjualan->user->name }}
                                                </a>
                                            @else
                                                {{ $penjualan->user->name }}
                                            @endif
                                        </td>
                                        <td class="text-nowrap ">
                                            Rp. {{ number_format($penjualan->subtotal, 0, ',', '.') }}
                                        </td>

                                        <td class="text-nowrap ">
                                            Rp. {{ number_format($penjualan->total_bayar, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="5"></th>
                                    <th class="text-nowrap">Total :</th>
                                    <th class="text-nowrap">
                                        Rp. {{ number_format($penjualans->sum('subtotal'), 0, ',', '.') }}
                                    </th>
                                    <th class="text-nowrap">
                                        Rp. {{ number_format($penjualans->sum('total_bayar'), 0, ',', '.') }}
                                    </th>
                                </tr>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- penjualan IMEI --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="text-danger">Penjualan IMEI</h3>
                    <div class="card-header-actions mb-4">
                        <form action="{{ route('rekap.export.imei') }}" method="post" target="_blank">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="username" value="{{ request('username') }}">

                            <button type="submit"
                                class="btn btn-success d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-excel" style="margin: -10px 2px 0 0"></i>
                                Export Excel
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">

                    {{-- menampilkan data dari get request search  --}}
                    @if (request('start_date') || request('end_date') || request('search') || request('username'))
                        <table class="mb-4">
                            <tr>
                                <th class="text-nowrap me-lg-2">Mulai Tanggal</th>
                                <td class="text-nowrap">: </td>
                                <td class="text-nowrap">
                                    {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-nowrap me-lg-2">Sampai Tanggal</th>
                                <td class="text-nowrap">: </td>
                                <td class="text-nowrap">
                                    {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->isoFormat('D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            @if (request()->is('rekap/agen*') || request('search') || request('username'))
                                <tr>
                                    <th class="text-nowrap me-lg-2">Nama Agen/Sales</th>
                                    <td class="text-nowrap">:</td>
                                    <td class="text-nowrap">
                                        {{ $displayPerUser }}
                                    </td>
                                </tr>
                            @endif
                        </table>
                    @endif

                    <div class="table-responsive pt-2 pe-2" id="table-container">
                        <div class="dropdown" id="dropdown-columns2">
                            <button class="btn btn-danger btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-funnel"></i>
                                <span class="visually-hidden">Filter</span>
                            </button>
                            <div class="dropdown-menu">
                                <h2 class="dropdown-header fs-5" style="margin: 0 0 -10px -10px">Tampilkan Kolom</h2>
                                <div id="toggle-columns-imei" class="p-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="0"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">IMEI</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="1"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Tipe</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="2"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Tanggal Transaksi</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="3"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Pelanggan</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="4"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Agen</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="5"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Biaya</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="6"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Modal</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="7"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">DP Server</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="8"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Sisa Server</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-column-imei="9"
                                            data-name-imei="imei_rekap" checked>
                                        <label class="form-check-label">Profit</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="loadingImei" style="display: none" class="spinner-border spinner-border-sm text-danger"
                        role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>

                    <table class="table table-striped table-hover" id="tableImei">
                        <thead>
                            <tr>
                                <th class="text-nowrap w-xl-50">IMEI</th>
                                <th class="text-nowrap">Tipe</th>
                                <th class="text-nowrap">Tanggal Transaksi</th>
                                <th class="text-nowrap">Pelanggan</th>
                                <th class="text-nowrap">Agen</th>
                                <th class="text-nowrap">Biaya</th>
                                <th class="text-nowrap">Modal</th>
                                <th class="text-nowrap">DP Server</th>
                                <th class="text-nowrap">Sisa Server</th>
                                <th class="text-nowrap">Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jasa_imeis as $jasa_imei)
                                <tr>
                                    <td class="text-nowrap w-xl-50">{{ $jasa_imei->imei }}</td>
                                    <td class="text-nowrap">{{ $jasa_imei->tipe }}</td>
                                    <td class="text-nowrap">
                                        {{ \Carbon\Carbon::parse($jasa_imei->tanggal)->isoFormat('D MMMM YY') }}
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $jasa_imei->pelanggan->nama_pelanggan }}
                                    </td>
                                    <td class="text-nowrap">
                                        @if (request()->is('rekap/agen*'))
                                            <a href="{{ route('rekap.agen', ['username' => $jasa_imei->user->username]) }}"
                                                style="text-decoration: underline;">
                                                {{ $jasa_imei->user->name }}
                                            </a>
                                        @else
                                            {{ $jasa_imei->user->name }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        Rp. {{ number_format($jasa_imei->biaya, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap">
                                        Rp. {{ number_format($jasa_imei->modal, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap">
                                        Rp. {{ number_format($jasa_imei->dp_server, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap">
                                        Rp. {{ number_format($jasa_imei->sisa_server, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap">
                                        Rp. {{ number_format($jasa_imei->profit, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4"></th>
                                <th class="text-nowrap">Total :</th>
                                <th class="text-nowrap">
                                    Rp. {{ number_format($jasa_imeis->sum('biaya'), 0, ',', '.') }}
                                </th>
                                <th class="text-nowrap">
                                    Rp. {{ number_format($jasa_imeis->sum('modal'), 0, ',', '.') }}
                                </th>
                                <th class="text-nowrap">
                                    Rp. {{ number_format($jasa_imeis->sum('dp_server'), 0, ',', '.') }}
                                </th>
                                <th class="text-nowrap">
                                    Rp. {{ number_format($jasa_imeis->sum('sisa_server'), 0, ',', '.') }}
                                </th>
                                <th class="text-nowrap">
                                    Rp. {{ number_format($jasa_imeis->sum('profit'), 0, ',', '.') }}
                                </th>
                            </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
        @endif

    </section>
@endsection

@push('scripts')
    {{-- @vite(['resources/js/datatables.js', 'resources/js/choices.js']) --}}

    <script type="module" src="{{ asset('static/js/datatables/dataTables.js') }}"></script>
    <script type="module" src="{{ asset('static/js/datatables/dataTablesImei.js') }}"></script>
    <script type="module" src="{{ asset('build/assets/choices-HcjBDTwy.js') }}"></script>
    @include('components.sweetalert2.alert')
    @include('components.ui.loading.button')
@endpush
