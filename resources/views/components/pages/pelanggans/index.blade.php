@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <a href={{ route('master-data.pelanggan.create') }} style="margin:-8px 0 0 0;"
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
                                    <input class="form-check-input" type="checkbox" data-column="0" data-name="pelanggan"
                                        checked>
                                    <label class="form-check-label">Nama Pelanggan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="1" data-name="pelanggan"
                                        checked>
                                    <label class="form-check-label">No WhatsApp</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="2" data-name="pelanggan"
                                        checked>
                                    <label class="form-check-label">Jumlah Transaksi</label>
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
                                <th class="text-nowrap w-xl-50">Nama Pelanggan</th>
                                <th class="text-nowrap w-xl-50">No WhatsApp</th>
                                <th class="text-nowrap w-xl-50">Jumlah Transaksi</th>
                                <th class="text-nowrap text-center" data-orderable="false">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggans as $pelanggan)
                                <tr>
                                    <td class="text-nowrap w-xl-50">{{ $pelanggan->nama_pelanggan }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $pelanggan->nomor_wa_formatted }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $pelanggan->jumlah_transaksi }}</td>
                                    <td class="text-nowrap text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            @if (Auth::user()->hasRole(['super_admin', 'admin', 'agen']))
                                                {{-- @if (!Auth::user()->hasRole(['agen']))
                                                    <a href={{ route('master-data.pelanggan.show', $pelanggan->id) }}
                                                        class="btn btn-secondary btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif --}}

                                                <a href="{{ route('master-data.pelanggan.edit', $pelanggan->id) }}"
                                                    class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                @if (!Auth::user()->hasRole('agen'))
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete-modal"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalStock{{ $pelanggan->id }}"
                                                        data-bs-placement="top" title="Hapus">
                                                        <i class="bi bi-trash text-white"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade text-left modal-borderless" id="modalStock{{ $pelanggan->id }}"
                                    tabindex="-1" aria-labelledby="modalStockLabel" style="display: none;"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" role="document"
                                        style="z-index: 30;">
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
                                                Apakah Anda yakin ingin menghapus data
                                                <span class="font-bold italic">'{{ $pelanggan->nama_pelanggan }}'</span>?
                                                {{-- Jika dihapus, seluruh data terkait penjualan atau IMEI akan ikut terhapus. --}}
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Batal</span>
                                                </button>

                                                <form action={{ route('master-data.pelanggan.destroy', $pelanggan->id) }}
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
