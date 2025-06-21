@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            @if (!Auth::user()->hasRole('owner'))
                <a href={{ route('master-data.barang.create') }} style="margin:-8px 0 0 0;"
                    class="d-inline-flex align-items-center btn btn-success btn-sm">
                    <i class="bi bi-folder-plus" style="margin: -12px 8px 0 0; font-size: 18px;"></i>
                    <span>Tambah Data</span>
                </a>
            @endif
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
                                    <input class="form-check-input" type="checkbox" data-column="0" data-name="barang"
                                        checked>
                                    <label class="form-check-label">Kode Barang</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="1" data-name="barang"
                                        checked>
                                    <label class="form-check-label">Nama Barang</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="2" data-name="barang"
                                        checked>
                                    <label class="form-check-label">Merk</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="3" data-name="barang"
                                        checked>
                                    <label class="form-check-label">Tipe</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="4" data-name="barang"
                                        checked>
                                    <label class="form-check-label">Memori</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="5" data-name="barang"
                                        checked>
                                    <label class="form-check-label">Warna</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="6" data-name="barang"
                                        checked>
                                    <label class="form-check-label">Satuan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="7" data-name="barang"
                                        checked>
                                    <label class="form-check-label">Kategori</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="8" data-name="barang">
                                    <label class="form-check-label">Grade</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="9" data-name="barang">
                                    <label class="form-check-label">Keterangan</label>
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
                                <th class="text-nowrap w-xl-50">Kode Barang</th>
                                <th class="text-nowrap w-xl-50">Nama Barang</th>
                                <th class="text-nowrap w-xl-50">Merk</th>
                                <th class="text-nowrap w-xl-50">Tipe</th>
                                <th class="text-nowrap w-xl-50">Memori</th>
                                <th class="text-nowrap w-xl-50">Warna</th>
                                <th class="text-nowrap w-xl-50">Satuan</th>
                                <th class="text-nowrap w-xl-50">Kategori</th>
                                <th class="text-nowrap w-xl-50">Grade</th>
                                <th class="text-nowrap w-xl-50">Keterangan</th>
                                <th class="text-nowrap text-center" data-orderable="false">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $barang)
                                <tr>
                                    <td class="text-nowrap w-xl-50">{{ $barang->kode_barang }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $barang->nama_barang }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $barang->merk }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $barang->tipe }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $barang->memori }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $barang->warna }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $barang->satuan }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $barang->kategori }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $barang->grade }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $barang->keterangan ?? '-' }}</td>
                                    <td class="text-nowrap text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            @if (Auth::user()->hasRole(['super_admin', 'owner', 'admin', 'agen']))
                                                @if (!Auth::user()->hasRole(['agen']))
                                                    <a href={{ route('master-data.barang.show', $barang->kode_barang) }}
                                                        class="btn btn-secondary btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif
                                                @if (!Auth::user()->hasRole('owner'))
                                                    <a href="{{ route('master-data.barang.edit', $barang->kode_barang) }}"
                                                        class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    @if (!Auth::user()->hasRole('agen'))
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm btn-delete-modal"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalStock{{ $barang->kode_barang }}"
                                                            data-bs-placement="top" title="Hapus">
                                                            <i class="bi bi-trash text-white"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade text-left modal-borderless"
                                    id="modalStock{{ $barang->kode_barang }}" tabindex="-1"
                                    aria-labelledby="modalStockLabel" style="display: none;" aria-hidden="true">
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

                                                <form action={{ route('master-data.barang.destroy', $barang->id) }}
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
    {{-- @vite('resources/js/datatables.js') --}}
    <script type="module" src="{{ asset('static/js/datatables/dataTables.js') }}"></script>
    @include('components.sweetalert2.alert')
    @include('components.ui.loading.button')
@endpush
