@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Stok HP</h2>
            @if (!Auth::user()->hasRole('owner'))
                <a href={{ route('stocks.create') }} style="margin:-8px 0 0 0;"
                    class="d-inline-flex align-items-center btn btn-success btn-sm">
                    <i class="bi bi-folder-plus" style="margin: -12px 8px 0 0; font-size: 18px;"></i>
                    <span>Tambah Stok</span>
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
                <div class="table-responsive  pt-2 pe-2" id="table-container">
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
                                    <input class="form-check-input" type="checkbox" data-column="0" data-name="stock">
                                    <label class="form-check-label">Foto</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="1" data-name="stock"
                                        checked>
                                    <label class="form-check-label">Kode Barang</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="2" data-name="stock"
                                        checked>
                                    <label class="form-check-label">Nama Barang</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="3" data-name="stock">
                                    <label class="form-check-label">Satuan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="4" data-name="stock"
                                        checked>
                                    <label class="form-check-label">Kategori</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="5" data-name="stock">
                                    <label class="form-check-label">Grade</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="6" data-name="stock">
                                    <label class="form-check-label">IMEI 1</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="7" data-name="stock">
                                    <label class="form-check-label">IMEI 2</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="8" data-name="stock"
                                        checked>
                                    <label class="form-check-label">Jumlah Stok</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="9" data-name="stock">
                                    <label class="form-check-label">Modal</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="10" data-name="stock"
                                        checked>
                                    <label class="form-check-label">Harga Jual</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="11" data-name="stock">
                                    <label class="form-check-label">Invoice</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="12" data-name="stock"
                                        checked>
                                    <label class="form-check-label">Supplier</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="13" data-name="stock">
                                    <label class="form-check-label">No Kontak Supplier</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="14" data-name="stock">
                                    <label class="form-check-label">Tanggal</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" data-column="15" data-name="stock">
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
                                <th class="text-nowrap w-xl-50" data-orderable="false">Foto</th>
                                <th class="text-nowrap w-xl-50">Kode Barang</th>
                                <th class="text-nowrap w-xl-50">Nama Barang</th>
                                <th class="text-nowrap w-xl-50">Satuan</th>
                                <th class="text-nowrap w-xl-50">Kategori</th>
                                <th class="text-nowrap w-xl-50">Grade</th>
                                <th class="text-nowrap w-xl-50">IMEI 1</th>
                                <th class="text-nowrap w-xl-50">IMEI 2</th>
                                <th class="text-nowrap w-xl-50">Jumlah Stok</th>
                                <th class="text-nowrap w-xl-50">Modal</th>
                                <th class="text-nowrap w-xl-50">Harga Jual</th>
                                <th class="text-nowrap w-xl-50">Invoice</th>
                                <th class="text-nowrap w-xl-50">Supplier</th>
                                <th class="text-nowrap w-xl-50">No Kontak Supplier</th>
                                <th class="text-nowrap w-xl-50">Tanggal</th>
                                <th class="text-nowrap w-xl-50">Keterangan</th>
                                <th class="text-nowrap text-center" data-orderable="false">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td class="text-nowrap w-xl-50 overflow-hidden">
                                        <img src="{{ $stock->barang->getFirstMediaUrl('barang') ?: asset('static/img/blank_image.webp') }}"
                                            alt="{{ $stock->barang->nama_barang }}" width="70" loading="lazy">
                                    </td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->barang->kode_barang }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->barang->nama_barang }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->barang->satuan }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->barang->kategori }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->barang->grade }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->imei_1 }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->imei_2 }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->jumlah_stok }}</td>
                                    <td class="text-nowrap w-xl-50">
                                        Rp. {{ number_format($stock->modal, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap w-xl-50">
                                        Rp. {{ number_format($stock->harga_jual, 0, ',', '.') }}
                                    </td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->invoice }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->supplier }}</td>
                                    <td class="text-nowrap w-xl-50">
                                        {{ $stock->NoKontakSupplier ? $stock->NoKontakSupplier : 'Tidak Ada' }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->tanggal }}</td>
                                    <td class="text-nowrap w-xl-50">{{ $stock->barang->keterangan }}</td>
                                    <td class="text-nowrap text-center">
                                        @if (Auth::user()->hasRole(['admin', 'agen']))
                                            <div class="dropdown">
                                                {{-- <a href="#" class="d-inline-flex" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots text-secondary details-button"
                                                        style="font-size: 18px;"></i>
                                                </a> --}}
                                                {{-- <ul class="dropdown-menu" style="z-index:50;position: relative;">
                                                    @if (!Auth::user()->hasRole('agen'))
                                                        <li class="border-bottom">
                                                            <a href={{ route('stocks.show', $stock->id) }}
                                                                class="dropdown-item">
                                                                <i class="bi bi-eye" style="margin: -2px 8px 0 0;"></i>
                                                                <sp an>Detail</sp>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a href={{ route('stocks.edit', $stock->id) }}
                                                            class="dropdown-item">
                                                            <i class="bi bi-pencil" style="margin: -2px 8px 0 0;"></i>
                                                            <span>Edit</span>
                                                        </a>
                                                    </li>
                                                    @if (!Auth::user()->hasRole('agen'))
                                                        <li>
                                                            <button type="button" class="dropdown-item btn-delete-modal"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalStock{{ $stock->id }}">
                                                                <i class="bi bi-trash" style="margin: -2px 8px 0 0;"></i>
                                                                <span>Hapus</span>
                                                            </button>
                                                        </li>
                                                    @endif
                                                </ul> --}}

                                            </div>

                                            <div class="d-flex gap-1 justify-content-end">
                                                @if (!Auth::user()->hasRole('agen'))
                                                    <a href="{{ route('stocks.show', $stock->id) }}"
                                                        class="btn btn-secondary btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('stocks.edit', $stock->id) }}"
                                                    class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                @if (!Auth::user()->hasRole('agen'))
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete-modal"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalStock{{ $stock->id }}"
                                                        data-bs-placement="top" title="Hapus">
                                                        <i class="bi bi-trash text-white"></i>
                                                    </button>
                                                @endif

                                            </div>
                                        @elseif (Auth::user()->hasRole('owner'))
                                            <a class="btn btn-secondary btn-sm d-inline-flex align-items-center"
                                                href="{{ route('stocks.show', $stock->id) }}">
                                                <i class="bi bi-eye" style="margin: 0 0 6px 0"></i>
                                                <span class="visually-hidden">Detail</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @if (!Auth::user()->hasRole('agen'))
                                    <div class="modal fade text-left modal-borderless" id="modalStock{{ $stock->id }}"
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

                                                    <form action={{ route('stocks.destroy', $stock->id) }} method="POST"
                                                        id="formSubmit">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger me-3 "
                                                            id="submitBtn">
                                                            <span class="d-none d-sm-block">Hapus</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
