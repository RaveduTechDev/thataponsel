@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <a href={{ route('penjualan.create') }} style="margin:-8px 0 0 0;"
                class="d-inline-flex align-items-center btn btn-success btn-md">
                <i class="bi bi-folder-plus" style="margin: -12px 8px 0 0; font-size: 18px;"></i>
                <span>Tambah Data</span>
            </a>
        </div>

        <div class="card">
            <div class="card-body">
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
                                    <input class="form-check-input" type="checkbox" data-column="6" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Total Bayar</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="7" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Status</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="loading" style="display: none" class="spinner-border spinner-border-sm text-danger"
                        role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>

                    <table class="table" id="table1">
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
                                    <td class="text-nowrap ">{{ $penjualan->tanggal_transaksi }}</td>
                                    <td class="text-nowrap ">{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                                    <td class="text-nowrap ">{{ $penjualan->tokoCabang->nama_toko_cabang }}</td>
                                    <td class="text-nowrap ">{{ $penjualan->agent->nama_agen }}</td>
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

    @vite('resources/js/datatables.js')
    @include('components.sweetalert2.alert')
    @include('components.ui.loading.button')
@endsection
