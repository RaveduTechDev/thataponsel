@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <div class="d-inline-flex align-items-center">
                @if (Auth::user()->hasRole(['super_admin', 'admin']))
                    <button type="button" class="btn btn-danger btn-sm btn-sm d-inline-flex align-items-center me-2"
                        data-bs-toggle="modal" data-bs-target="#modalBarang">
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
                                    <form action="{{ route('jasa-imei.destroy', $jasa_imei->id) }}" method="POST">
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
                @endif
                <a href="{{ route('jasa-imei.index') }}" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                    <i class="bi bi-arrow-left" style="margin: -8px 4px 0 0;"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if (Auth::user()->hasRole(['super_admin', 'admin']))
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <a href="{{ route('jasa-imei.edit', $jasa_imei->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                @endif
                <table class="table table-borderless table-striped table-hover">
                    <tbody>
                        <tr>
                            <th scope="row">Pelanggan</th>
                            <td>{{ $jasa_imei->pelanggan->nama_pelanggan }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tipe</th>
                            <td>{{ $jasa_imei->tipe }}</td>
                        </tr>
                        <tr>
                            <th scope="row">IMEI</th>
                            <td>{{ $jasa_imei->imei }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Biaya</th>
                            <td>Rp. {{ number_format($jasa_imei->biaya, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Modal</th>
                            <td>Rp. {{ number_format($jasa_imei->modal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Profit</th>
                            <td>Rp. {{ number_format($jasa_imei->profit, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Supplier</th>
                            <td>{{ $jasa_imei->supplier }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Admin</th>
                            <td>{{ $jasa_imei->user->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>{{ $jasa_imei->status }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tanggal Masuk</th>
                            <td>{{ $jasa_imei->created_at->isoFormat('D MMMM Y') }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tanggal Update</th>
                            @if ($jasa_imei->status == 'selesai')
                                <td>{{ $jasa_imei->updated_at->isoFormat('D MMMM Y') }}</td>
                            @else
                                <td>-</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection
