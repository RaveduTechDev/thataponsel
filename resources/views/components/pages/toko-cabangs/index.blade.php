@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <a href={{ route('master-data.toko-cabang.create') }} style="margin:-8px 0 0 0;"
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
                                    <input class="form-check-input" type="checkbox" data-column="0" data-name="toko-cabang"
                                        checked>
                                    <label class="form-check-label">Nama Toko Cabang</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="1" data-name="toko-cabang"
                                        checked>
                                    <label class="form-check-label">Penanggung Jawab</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="2" data-name="toko-cabang"
                                        checked>
                                    <label class="form-check-label">Alamat</label>
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
                                <th class="text-nowrap w-xl-50">Nama Toko Cabang</th>
                                <th class="text-nowrap w-xl-50">Penanggung Jawab</th>
                                <th class="text-nowrap w-xl-50">Alamat</th>
                                <th class="text-nowrap text-center" data-orderable="false">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($toko_cabangs as $toko_cabang)
                                <tr>
                                    <td class="text-nowrap w-xl-50">{{ $toko_cabang->nama_toko_cabang }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $toko_cabang->penanggung_jawab_toko }}</td>
                                    <td class="text-wrap w-xl-50">{{ $toko_cabang->alamat_toko }}</td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <a href="#" class="d-inline-flex" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots text-secondary details-button"
                                                    style="font-size: 18px;"></i>
                                            </a>
                                            <ul class="dropdown-menu" style="z-index:50;position: relative;">
                                                <li>
                                                    <a href={{ route('master-data.pelanggan.edit', $toko_cabang->id) }}
                                                        class="dropdown-item">
                                                        <i class="bi bi-pencil" style="margin: -2px 8px 0 0;"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item btn-delete-modal"
                                                        data-bs-toggle="modal" data-bs-target="#modalStock">
                                                        <i class="bi bi-trash" style="margin: -2px 8px 0 0;"></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade text-left modal-borderless" id="modalStock" tabindex="-1"
                                    aria-labelledby="modalStockLabel" style="display: none;" aria-hidden="true">
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
                                                Yakin Ingin Menghapus Data Ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Batal</span>
                                                </button>

                                                <form action={{ route('master-data.pelanggan.destroy', $toko_cabang->id) }}
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
