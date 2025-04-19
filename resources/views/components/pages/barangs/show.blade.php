@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <div class="gap-2 d-flex justify-content-between justify-content-sm-end">
                @if (!Auth::user()->hasRole('owner'))
                    <button type="button" class="btn btn-danger btn-sm d-inline-flex justify-content-center w-100"
                        data-bs-toggle="modal" data-bs-target="#modalBarang">
                        <i class="bi bi-trash" style="margin: -2px 2px 0 0; font-size: 15px;"></i>
                        <span>Hapus</span>
                    </button>
                    <div class="modal fade text-left modal-borderless" id="modalBarang" tabindex="-1"
                        aria-labelledby="modalBarangLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"
                            style="z-index: 30;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="modalBarangLabel">
                                        <i class="bi bi-exclamation-triangle-fill fs-5" style="margin-top:-8px;"></i>
                                        <span>Peringatan</span>
                                    </h5>
                                    <button type="button" class="close text-danger close-btn" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="bi bi-x-lg fs-6"></i>
                                        <span class="visually-hidden">Close</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Yakin Ingin Menghapus Data Ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-block">Batal</span>
                                    </button>
                                    <form action="{{ route('master-data.barang.destroy', $barang->id) }}" method="POST"
                                        id="formSubmit">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ms-1 d-inline-flex" id="submitBtn">
                                            <i class="bi bi-trash" style="margin: -1px 6px 0 0;"></i>
                                            <span class="d-none d-sm-block">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <a href="{{ route('master-data.barang.index') }}"
                    class="btn btn-secondary btn-sm d-inline-flex justify-content-center w-100">
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        <div class="card shadow-sm p-4">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ $barang->getFirstMediaUrl('barang') ?: asset('static/img/blank_image.webp') }}"
                        class="img-fluid rounded w-100" alt="{{ $barang->nama_barang }}" loading="lazy">
                </div>

                <div class="col-md-8 mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-6">
                            <table class="table table-borderless table-show mb-0">
                                <tr>
                                    <th>Kode Barang:</th>
                                </tr>
                                <tr>
                                    <td>{!! $barang->kode_barang !!}</td>
                                </tr>
                                <tr>
                                    <th>Nama Barang:</th>
                                </tr>
                                <tr>
                                    <td>{!! $barang->nama_barang !!}</td>
                                </tr>
                                <tr>
                                    <th>Merk:</th>
                                </tr>
                                <tr>
                                    <td>{!! $barang->merk !!}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-6">
                            <table class="table table-borderless table-show mb-0">
                                <tr>
                                    <th>Tipe:</th>
                                </tr>
                                <tr>
                                    <td>{!! $barang->tipe !!}</td>
                                </tr>
                                <tr>
                                    <th>Memori:</th>
                                </tr>
                                <tr>
                                    <td>{!! $barang->memori !!}</td>
                                </tr>
                                <tr>
                                    <th>Warna:</th>
                                </tr>
                                <tr>
                                    <td>{!! $barang->warna !!}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-6">
                            <table class="table table-borderless table-show mb-0">
                                <tr>
                                    <th>Satuan:</th>
                                </tr>
                                <tr>
                                    <td>{!! $barang->satuan !!}</td>
                                </tr>
                                <tr>
                                    <th>Kategori:</th>
                                </tr>
                                <tr>
                                    <td>{!! $barang->kategori !!}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-6">
                            <table class="table table-borderless table-show mb-0">
                                <tr>
                                    <th>Grade:</th>
                                </tr>
                                <tr>
                                    <td>{!! $barang->grade !!}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan:</th>
                                </tr>
                                <tr>
                                    <td>{!! $barang->keterangan !!}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                @if (!Auth::user()->hasRole('owner'))
                    <div class="d-flex gap-3 justify-content-end mt-3">
                        <a href="{{ route('master-data.barang.edit', $barang->kode_barang) }}"
                            class="btn btn-primary justify-content-center d-inline-flex">
                            <i class="bi bi-pencil" style="margin: -2px 6px 0 0; font-size: 16px;"></i>
                            <span>Edit</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        </div>
    </section>

    @include('components.ui.loading.button')
@endsection
