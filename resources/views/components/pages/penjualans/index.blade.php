@extends('layouts.app')

@section('content')
    <section class="section">
        @csrf
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <div class="d-flex align-items-center justify-content-between justify-content-md-end">
                @if (!Auth::user()->hasRole('owner'))
                    <a href="{{ route('penjualan.create') }}"
                        class="btn btn-success btn-sm d-inline-flex align-items-center justify-content-center me-2">
                        <i class="bi bi-folder-plus me-2" style="margin: -12px 2px 0 0; font-size: 18px;"></i>
                        <span>Tambah Data</span>
                    </a>
                @endif

                <form action="{{ route('penjualan.export') }}" method="POST" id="form-export" class="user-select-none">
                    @csrf
                    <input type="hidden" name="ids" id="ids">
                    <input type="hidden" name="export" id="export">

                    <button type="button" data-action="pdf" id="btn-export-pdf" style="cursor: not-allowed"
                        class="btn btn-danger btn-sm d-inline-flex justify-content-center align-items-center btn-export me-1">
                        <i class="bi bi-file-earmark-pdf" style="margin: -14px 2px 0 0; font-size: 18px;"></i>
                        Cetak PDF
                    </button>

                    <button type="button" data-action="excel" id="btn-export-excel"
                        class="btn btn-primary btn-sm d-inline-flex justify-content-center align-items-center btn-export">
                        <i class="bi bi-file-earmark-excel" style="margin: -14px 2px 0 0; font-size: 18px;"></i>
                        Cetak Excel
                    </button>
                </form>
            </div>
        </div>

        @if ($errors->has('ids'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-error">
                <strong>Terjadi Kesalahan!</strong> {{ $errors->first('ids') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                            <div id="toggle-columns" class="p-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="0" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Kotak Centang</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="1" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Invoice</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="2" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Tanggal Transaksi</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="3" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Pelanggan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="4" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Nama Barang</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="5" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Toko Cabang</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="6" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Agent</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="7" data-name="penjualan"
                                        checked>
                                    <label class="form-check-label">Jumlah Barang</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="8"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Sub Total</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="9"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Diskon (%)</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="10"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Total Bayar</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="11"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Metode Pembayaran</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="12"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Garansi</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="13"
                                        data-name="penjualan" checked>
                                    <label class="form-check-label">Keterangan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="14"
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

                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th data-orderable="false">
                                    <input type="checkbox" class="form-check-input" style="cursor: pointer"
                                        id="select-all">
                                </th>
                                <th class="text-nowrap w-xl-50">Invoice</th>
                                <th class="text-nowrap">Tanggal Transaksi</th>
                                <th class="text-nowrap">Pelanggan</th>
                                <th class="text-nowrap">Nama Barang</th>
                                <th class="text-nowrap">Toko Cabang</th>
                                <th class="text-nowrap">Agent</th>
                                <th class="text-nowrap">Jumlah Barang</th>
                                <th class="text-nowrap">Sub Total</th>
                                <th class="text-nowrap">Diskon(%)</th>
                                <th class="text-nowrap">Total Bayar</th>
                                <th class="text-nowrap">Metode Pembayaran</th>
                                <th class="text-nowrap">Garansi</th>
                                <th class="text-nowrap">Keterangan</th>
                                <th class="text-nowrap">Status</th>
                                @if (!Auth::user()->hasRole(['agen', 'owner']))
                                    <th class="text-nowrap text-center" data-orderable="false">Opsi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualans as $penjualan)
                                <tr>
                                    <td>
                                        <input type="checkbox" style="cursor: pointer"
                                            class="form-check-input row-checkbox" id="" name="ids[]"
                                            value="{{ $penjualan->id }}">
                                    </td>
                                    <td class="text-nowrap w-xl-50">{{ $penjualan->invoice }}</td>
                                    <td class="text-nowrap ">
                                        {{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td class="text-nowrap ">{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                                    <td class="text-nowrap ">
                                        {{ $penjualan->stock->barang->nama_barang }}
                                    </td>
                                    <td class="text-nowrap ">{{ $penjualan->tokoCabang->nama_toko_cabang }}</td>
                                    <td class="text-nowrap ">{{ $penjualan->user->name }}</td>
                                    {{-- qty --}}
                                    <td class="text-nowrap ">
                                        {{ $penjualan->qty }}
                                    </td>
                                    <td class="text-nowrap ">
                                        Rp. {{ number_format($penjualan->subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap ">{{ $penjualan->diskon }}%</td>
                                    <td class="text-nowrap ">
                                        Rp. {{ number_format($penjualan->total_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap">
                                        {{ ucwords($penjualan->metode_pembayaran) }}
                                    </td>
                                    <td class="text-nowrap ">{{ ucwords($penjualan->stock->garansi) }}</td>
                                    <td class="text-nowrap ">{{ $penjualan->stock->barang->keterangan }}</td>
                                    <td class="text-nowrap ">
                                        @if ($penjualan->status == 'selesai')
                                            <span class="badge text-bg-success rounded-pill">
                                                {{ ucwords($penjualan->status) }}
                                            </span>
                                        @elseif ($penjualan->status == 'proses')
                                            <span class="badge text-bg-warning rounded-pill">
                                                {{ ucwords($penjualan->status) }}
                                            </span>
                                        @else
                                            <span class="badge text-bg-danger rounded-pill">
                                                {{ ucwords($penjualan->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    @if (Auth::user()->hasRole(['super_admin', 'admin']))
                                        <td class="text-nowrap text-center">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href={{ route('penjualan.show', $penjualan->id) }}
                                                    class="btn btn-secondary btn-sm" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                @if ($penjualan->status !== 'selesai')
                                                    <a href={{ route('penjualan.edit', $penjualan->id) }}
                                                        class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Edit">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                @endif

                                                <button type="button" class="btn btn-danger btn-sm btn-delete-modal"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalStock{{ $penjualan->id }}"
                                                    data-bs-placement="top" title="Hapus">
                                                    <i class="bi bi-trash text-white"></i>
                                                </button>
                                            </div>
                                        </td>
                                    @endif
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
                                                    method="POST" class="formSubmit">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger me-3 submitBtn">
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
