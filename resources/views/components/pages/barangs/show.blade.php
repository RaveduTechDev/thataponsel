@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalBarang">
                <i class="bi bi-trash" style="margin: -12px 2px 0 0; font-size: 18px;"></i>
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
                                <span class="d-none d-sm-block">Batal</span>
                            </button>
                            <form action="{{ route('master-data.barang.destroy', $barang->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ms-1 d-flex">
                                    <i class="bi bi-trash" style="margin: -1px 6px 0 0;"></i>
                                    <span class="d-none d-sm-block">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm p-4">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ $barang->getFirstMediaUrl('barang') }}" class="img-fluid rounded w-100"
                        alt="Product Image">
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

                <div class="d-flex gap-3 justify-content-end mt-3">
                    <a href="{{ route('master-data.barang.edit', $barang->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil" style="margin: -12px 2px 0 0; font-size: 18px;"></i>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('master-data.barang.index') }}" class="btn btn-light-secondary">
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
