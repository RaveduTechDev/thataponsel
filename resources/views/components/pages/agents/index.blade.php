@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <a href={{ route('master-data.agent.create') }} style="margin:-8px 0 0 0;"
                class="d-inline-flex align-items-center btn btn-success btn-sm">
                <i class="bi bi-folder-plus" style="margin: -12px 8px 0 0; font-size: 18px;"></i>
                <span>Tambah Data</span>
            </a>
        </div>

        @if (session('message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ session('message') }}</span>
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
                            <div id="toggle-columns" class="card p-3 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="0" data-name="agent"
                                        checked>
                                    <label class="form-check-label">Nama Agen</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="1" data-name="agent"
                                        checked>
                                    <label class="form-check-label">No WhatsApp</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="2" data-name="agent"
                                        checked>
                                    <label class="form-check-label">Toko Cabang</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="3" data-name="agent"
                                        checked>
                                    <label class="form-check-label">Level</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="4" data-name="agent"
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
                                <th class="text-nowrap w-xl-50">Nama</th>
                                <th class="text-nowrap w-xl-50">No WhatsApp</th>
                                <th class="text-nowrap w-xl-50">Toko Cabang</th>
                                <th class="text-nowrap w-xl-50">Level</th>
                                <th class="text-nowrap w-xl-50">Jumlah Transaksi</th>
                                <th class="text-nowrap text-center" data-orderable="false">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agents as $agent)
                                <tr>
                                    <td class="text-nowrap w-xl-50">{{ $agent->name }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $agent->nomor_wa_agent_formatted }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $agent->tokoCabang->nama_toko_cabang ?? '' }}</td>
                                    <td class="text-nowrap w-xl-50">
                                        @foreach ($agent->getRoleNames() as $role)
                                            {{ ucwords(str_replace(['-', '_'], ' ', $role)) }}
                                        @endforeach
                                    </td>
                                    <td class="text-nowrap w-xl-50">{{ $agent->jumlah_transaksi }}</td>
                                    <td class="text-nowrap text-center">
                                        <div class="d-flex gap-1 align-items-center justify-content-center">
                                            <a href="{{ route('master-data.agent.edit', $agent->id) }}"
                                                class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btn-delete-modal"
                                                data-bs-toggle="modal" data-bs-target="#modalStock{{ $agent->id }}"
                                                data-id="{{ $agent->id }}" data-name="{{ $agent->name }}"
                                                data-bs-placement="top" title="Hapus">
                                                <i class="bi bi-trash text-white"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade text-left modal-borderless" id="modalStock{{ $agent->id }}"
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

                                                <form action={{ route('master-data.agent.destroy', $agent->id) }}
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
@endsection

@push('scripts')
    <script type="module" src="{{ asset('static/js/datatables/dataTables.js') }}"></script>
    {{-- @vite('resources/js/datatables.js') --}}
    @include('components.sweetalert2.alert')
    @include('components.ui.loading.button')
@endpush
