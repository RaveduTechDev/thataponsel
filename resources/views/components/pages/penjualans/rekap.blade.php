@extends('layouts.app')

@section('content')
    <section class="section">

        <div class="card">
            <div class="card-header mb-3">
                @if (request()->is('rekap'))
                    <h4 class="text-danger">Cari Berdasarkan Tanggal</h4>
                @elseif (request()->is('rekap/agen'))
                    <h4 class="text-danger">Cari Berdasarkan Agen/Sales</h4>
                @endif
            </div>

            <div class="card-body">
                <form
                    action="@if (request()->is('rekap')) {{ route('rekap') }} @elseif('rekap/agen') {{ route('rekap.agen') }} @endif"
                    method="GET" id="formSubmit" class="row g-3">
                    <div class="col-12 col-md-6 {{ request()->is('rekap/agen') ? 'col-lg-3' : 'col-lg-5' }}">
                        <label for="start_date" class="form-label">Mulai Tanggal</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-12 col-md-6 {{ request()->is('rekap/agen') ? 'col-lg-3' : 'col-lg-5' }}">
                        <label for="end_date" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ request('end_date') }}">
                    </div>
                    @if (request()->is('rekap/agen'))
                        <div class="col-12 col-md-8 col-lg-4">
                            <label for="agent_name" class="form-label">Nama Agen/Sales</label>
                            {{-- <input type="text" class="form-control" id="agent_name" name="search"
                                placeholder="Cari Agen/Sales" value="{{ request('agent_name') }}"> --}}
                            <select id="select-agent"
                                class="select-data form-select choice {{ $errors->has('agent_id') ? 'is-invalid' : '' }}"
                                style="cursor:pointer;" name="search" data-placeholder="-- Pilih Sales/Agent --"
                                data-check-selected="{{ request('search') ? 'true' : 'false' }}" required>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->nama_agen }}"
                                        {{ request('search') === $agent->nama_agen ? 'selected' : '' }}>
                                        {{ $agent->nama_agen }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div
                        class="col-12 {{ request()->is('rekap/agen') ? 'col-md-4' : 'col-md-12' }} col-lg-2 d-flex align-items-end">
                        <button type="submit" id="submitBtn"
                            class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-search me-1" style="margin-top: -10px"></i>
                            <span>Cari</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="text-danger">{{ $title }}</h3>
            </div>
            <div class="card-body">

                {{-- menampilkan data dari get request search  --}}
                @if (request('start_date') || request('end_date') || request('agent_name'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Hasil Pencarian:</strong>
                        @if (request('start_date'))
                            {{ request('start_date') }}
                        @endif
                        @if (request('end_date'))
                            {{ request('end_date') }}
                        @endif
                        @if (request('agent_name'))
                            {{ request('agent_name') }}
                        @endif
                    </div>
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
                            <div id="toggle-columns" class="card p-3 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="0" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Invoice</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="1" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Tanggal Transaksi</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="2" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Pelanggan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="3" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Toko Cabang</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="4" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Agent</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="5" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Sub Total</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="6"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Total Bayar</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="7"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Status</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="loading" style="display: none" class="spinner-border spinner-border-sm text-danger"
                        role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>

                    <table class="table table-striped table-hover" id="table1">
                        <thead>
                            <tr>
                                <th class="text-nowrap w-xl-50">Invoice</th>
                                <th class="text-nowrap">Tanggal Transaksi</th>
                                <th class="text-nowrap">Pelanggan</th>
                                <th class="text-nowrap">Toko Cabang</th>
                                <th class="text-nowrap">Agent</th>
                                <th class="text-nowrap">Sub Total</th>
                                <th class="text-nowrap">Diskon(%)</th>
                                <th class="text-nowrap">Total Bayar</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap text-center" data-orderable="false">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualans as $penjualan)
                                <tr>
                                    <td class="text-nowrap w-xl-50">{{ $penjualan->invoice }}</td>
                                    <td class="text-nowrap ">
                                        {{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->isoFormat('D MMMM YY') }}
                                    </td>
                                    <td class="text-nowrap ">{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                                    <td class="text-nowrap ">{{ $penjualan->tokoCabang->nama_toko_cabang }}</td>
                                    <td class="text-nowrap ">
                                        <a href="{{ route('rekap.agen', ['username' => $penjualan->agent->id]) }}"
                                            style="text-decoration: underline;">
                                            {{ $penjualan->agent->nama_agen }}
                                        </a>
                                    </td>
                                    <td class="text-nowrap ">
                                        Rp. {{ number_format($penjualan->subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap ">{{ $penjualan->diskon }}%</td>
                                    <td class="text-nowrap ">
                                        Rp. {{ number_format($penjualan->total_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap ">

                                        @if ($penjualan->status == 'selesai')
                                            <span class="badge text-bg-success rounded-pill">
                                                {{ $penjualan->status }}
                                            </span>
                                        @elseif ($penjualan->status == 'proses')
                                            <span class="badge text-bg-warning rounded-pill">
                                                {{ $penjualan->status }}
                                            </span>
                                        @else
                                            <span class="badge text-bg-danger rounded-pill">
                                                {{ $penjualan->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <a href="#" class="d-inline-flex" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots text-secondary details-button"
                                                    style="font-size: 18px;"></i>
                                            </a>
                                            <ul class="dropdown-menu" style="z-index:50;position: relative;">
                                                <li class="border-bottom">
                                                    <a href={{ route('penjualan.show', $penjualan->id) }}
                                                        class="dropdown-item">
                                                        <i class="bi bi-eye" style="margin: -2px 8px 0 0;"></i>
                                                        <span>Detail</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href={{ route('penjualan.edit', $penjualan->id) }}
                                                        class="dropdown-item">
                                                        <i class="bi bi-pencil" style="margin: -2px 8px 0 0;"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item btn-delete-modal"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalStock{{ $penjualan->id }}">
                                                        <i class="bi bi-trash" style="margin: -2px 8px 0 0;"></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade text-left modal-borderless" id="modalStock{{ $penjualan->id }}"
                                    tabindex="-1" aria-labelledby="modalStockLabel" style="display: none;"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable"
                                        role="document" style="z-index: 30;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger" id="modalStockLabel">
                                                    <i class="bi bi-exclamation-triangle-fill fs-5"
                                                        style="margin-top:-8px;"></i>
                                                    <span>Peringatan</span>
                                                </h5>
                                                <button type="button" class="close text-danger close-btn"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    <i class="bi bi-x-lg fs-6"></i>
                                                    <span class="visually-hidden">Close</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin Ingin Menghapus Data Ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Batal</span>
                                                </button>

                                                <form action={{ route('penjualan.destroy', $penjualan->id) }}
                                                    method="POST" id="formSubmit">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger me-3 " id="submitBtn">
                                                        <span class="d-none d-sm-block">Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @vite(['resources/js/datatables.js', 'resources/js/choices.js'])
    @include('components.sweetalert2.alert')
    @include('components.ui.loading.button')
@endsection
