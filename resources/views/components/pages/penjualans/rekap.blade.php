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
                    <div class="col-12 col-md-6 {{ request()->is('rekap/agen*') ? 'col-lg-3' : 'col-lg-5' }}">
                        <label for="start_date" class="form-label">Mulai Tanggal</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-12 col-md-6 {{ request()->is('rekap/agen*') ? 'col-lg-3' : 'col-lg-5' }}">
                        <label for="end_date" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ request('end_date') }}">
                    </div>
                    @if (request()->is('rekap/agen*'))
                        <div class="col-12 col-md-8 col-lg-4">
                            <label for="agent_name" class="form-label">Nama Agen/Sales</label>
                            <select id="select-agent"
                                class="select-data form-select choice {{ $errors->has('agent_id') ? 'is-invalid' : '' }}"
                                style="cursor:pointer;" name="search" data-placeholder="-- Pilih Sales/Agent --"
                                data-check-selected="{{ request('search') ? 'true' : 'false' }}">
                                <option></option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}"
                                        {{ $displayPerUser === $user->name ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div
                        class="col-12 {{ request()->is('rekap/agen*') ? 'col-md-4' : 'col-md-12' }} col-lg-2 d-flex align-items-end">
                        <button type="submit" id="submitBtn"
                            class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-search me-1" style="margin-top: -12px"></i>
                            <span>Cari</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- penjualan hp --}}
        <div class="card">
            <div class="card-header">
                <h3 class="text-danger mb-4">Penjualan HP</h3>
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
                                    <input class="form-check-input" type="checkbox" data-column="5"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Sub Total</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="6"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Total Bayar</label>
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
                                <th class="text-nowrap">Total Bayar</th>
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
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4"></th>
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
                <h3 class="text-danger mb-4">Penjualan IMEI</h3>
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
                                    <input class="form-check-input" type="checkbox" data-column="0"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Invoice</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="1"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Tanggal Transaksi</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="2"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Pelanggan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="3"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Toko Cabang</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="4"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Agent</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="5"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Sub Total</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="6"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Total Bayar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="loading" style="display: none" class="spinner-border spinner-border-sm text-danger"
                        role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>

                    <table class="table table-striped table-hover" id="tableImei">
                        <thead>
                            <tr>
                                <th class="text-nowrap w-xl-50">Invoice</th>
                                <th class="text-nowrap">Tanggal Transaksi</th>
                                <th class="text-nowrap">Pelanggan</th>
                                <th class="text-nowrap">Agent</th>
                                <th class="text-nowrap">Sub Total</th>
                                <th class="text-nowrap">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jasa_imeis as $jasa_imei)
                                <tr>
                                    <td class="text-nowrap w-xl-50">{{ $jasa_imei->imei }}</td>
                                    <td class="text-nowrap ">
                                        {{ \Carbon\Carbon::parse($jasa_imei->tanggal_transaksi)->isoFormat('D MMMM YY') }}
                                    </td>
                                    <td class="text-nowrap ">{{ $jasa_imei->pelanggan->nama_pelanggan }}</td>
                                    <td class="text-nowrap ">
                                        @if (request()->is('rekap/agen*'))
                                            <a href="{{ route('rekap.agen', ['username' => $jasa_imei->user->username]) }}"
                                                style="text-decoration: underline;">
                                                {{ $jasa_imei->user->name }}
                                            </a>
                                        @else
                                            {{ $jasa_imei->user->name }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap ">
                                        Rp. {{ number_format($jasa_imei->subtotal, 0, ',', '.') }}
                                    </td>

                                    <td class="text-nowrap ">
                                        Rp. {{ number_format($jasa_imei->total_bayar, 0, ',', '.') }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3"></th>
                                <th class="text-nowrap">Total :</th>
                                <th class="text-nowrap">
                                    Rp. {{ number_format($jasa_imeis->sum('subtotal'), 0, ',', '.') }}
                                </th>
                                <th class="text-nowrap">
                                    Rp. {{ number_format($jasa_imeis->sum('total_bayar'), 0, ',', '.') }}
                                </th>
                            </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    {{-- @vite(['resources/js/datatables.js', 'resources/js/choices.js']) --}}

    <script type="module" src="{{ asset('static/js/datatables/dataTables.js') }}"></script>
    <script type="module" src="{{ asset('static/js/datatables/dataTablesImei.js') }}"></script>
    <script type="module" src="{{ asset('build/assets/choices-BGT1ZLBO.js') }}"></script>
    @include('components.sweetalert2.alert')
    @include('components.ui.loading.button')
@endpush
