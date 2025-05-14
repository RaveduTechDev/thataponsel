@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            @if (!Auth::user()->hasRole('owner'))
                <a href="{{ route('jasa-imei.create') }}" style="margin:-8px 0 0 0;"
                    class="d-inline-flex align-items-center btn btn-success btn-md">
                    <i class="bi bi-folder-plus" style="margin: -12px 8px 0 0; font-size: 18px;"></i>
                    <span>Tambah Data</span>
                </a>
            @endif
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
                            <h2 class="fs-5" style="padding: 10px 10px 0;margin-bottom: -10px;">Tampilkan Kolom</h2>
                            <div id="toggle-columns" class="p-3 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="0" data-name="imei"
                                        checked>
                                    <label class="form-check-label">Pelanggan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="1" data-name="imei"
                                        checked>
                                    <label class="form-check-label">Tipe</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="2" data-name="imei"
                                        checked>
                                    <label class="form-check-label">IMEI</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="3" data-name="imei"
                                        checked>
                                    <label class="form-check-label">Biaya</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="4" data-name="imei"
                                        checked>
                                    <label class="form-check-label">Modal</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="5" data-name="imei"
                                        checked>
                                    <label class="form-check-label">Profit</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="6" data-name="imei"
                                        checked>
                                    <label class="form-check-label">Status</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="7" data-name="imei"
                                        checked>
                                    <label class="form-check-label">Supplier</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="8" data-name="imei"
                                        checked>
                                    <label class="form-check-label">Agen</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="9" data-name="imei"
                                        checked>
                                    <label class="form-check-label">Tanggal Transaksi</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="10" data-name="imei"
                                        checked>
                                    <label class="form-check-label">Tanggal Selesai</label>
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
                                <th class="text-nowrap w-xl-50">Pelanggan</th>
                                <th class="text-nowrap">Tipe</th>
                                <th class="text-nowrap">IMEI</th>
                                <th class="text-nowrap">Biaya</th>
                                <th class="text-nowrap">Modal</th>
                                <th class="text-nowrap">Profit</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap">Supplier</th>
                                <th class="text-nowrap">Agen</th>
                                <th class="text-nowrap">Tanggal Transaksi</th>
                                <th class="text-nowrap">Tanggal Selesai</th>
                                <th class="text-nowrap text-center" data-orderable="false">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jasa_imeis as $jasa_imei)
                                <tr>
                                    <td class="text-nowrap w-xl-50">{{ $jasa_imei->pelanggan->nama_pelanggan }}</td>
                                    <td class="text-nowrap">{{ $jasa_imei->tipe }}</td>
                                    <td class="text-nowrap">{{ $jasa_imei->imei }}</td>
                                    <td class="text-nowrap">Rp. {{ number_format($jasa_imei->biaya, 0, ',', '.') }}</td>
                                    <td class="text-nowrap">Rp. {{ number_format($jasa_imei->modal, 0, ',', '.') }}</td>
                                    <td class="text-nowrap">Rp. {{ number_format($jasa_imei->profit, 0, ',', '.') }}</td>
                                    <td class="text-nowrap">
                                        @if ($jasa_imei->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($jasa_imei->status == 'proses')
                                            <span class="badge bg-warning">Proses</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{ $jasa_imei->supplier }}</td>
                                    <td class="text-nowrap">{{ $jasa_imei->user->name }}</td>
                                    <td class="text-nowrap">{{ $jasa_imei->created_at->isoFormat('D MMMM Y') }}</td>
                                    <td class="text-nowrap">
                                        {{ $jasa_imei->status == 'selesai' ? $jasa_imei->updated_at->isoFormat('D MMMM Y') : 'Dalam Proses' }}
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            @if (Auth::user()->hasRole(['super_admin', 'owner', 'admin', 'agen']))
                                                @if (!Auth::user()->hasRole('agen'))
                                                    <a href="{{ route('jasa-imei.show', $jasa_imei->id) }}"
                                                        class="btn btn-icon btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Detail Data">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif
                                                @if (!Auth::user()->hasRole('owner'))
                                                    <a href="{{ route('jasa-imei.edit', $jasa_imei->id) }}"
                                                        class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Edit Data">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                @endif
                                                @if (!Auth::user()->hasRole(['agen', 'owner']))
                                                    <button type="button"
                                                        class="btn btn-icon btn-danger btn-sm btn-delete-modal"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalStock{{ $jasa_imei->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Hapus Data">
                                                        <i class="bi bi-trash text-white"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade text-left modal-borderless" id="modalStock{{ $jasa_imei->id }}"
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

                                                <form action={{ route('jasa-imei.destroy', $jasa_imei->id) }}
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
