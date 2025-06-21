@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Detail Stok</h2>
            <div class="d-flex gap-2">
                @if (!Auth::user()->hasRole(['agen', 'owner']))
                    <button type="button" class="btn btn-danger btn-sm d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#modalStock">
                        <i class="bi bi-trash" style="margin: -8px 1px 0 0;font-size: 14px;"></i>
                        <span>Hapus</span>
                    </button>
                    <div class="modal fade text-left modal-borderless" id="modalStock" tabindex="-1"
                        aria-labelledby="modalStockLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" role="document"
                            style="z-index: 30;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="modalStockLabel">
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

                                    <form action={{ route('stocks.destroy', $stock->id) }} method="POST">
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
                <a href="{{ route('stocks.index') }}"class="btn btn-secondary btn-sm">
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        <div class="card shadow-sm p-4">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ $stock->getFirstMediaUrl('stock') ?: $stock->barang->getFirstMediaUrl('barang') ?: asset('static/img/blank_image.webp') }}"
                        class="img-fluid rounded w-100" alt="{{ $stock->barang->nama_barang }}">
                </div>

                <div class="col-md-8 mt-4 mt-md-0">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-6">
                            <table class="table table-borderless table-show mb-0">
                                <tr>
                                    <th>Kode Barang:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->barang->kode_barang ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Barang:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->barang->nama_barang ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Memori:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->barang->memori ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Warna:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->barang->warna ?? '-' }}</td>
                                </tr>

                            </table>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-6">
                            <table class="table table-borderless table-show mb-0">
                                <tr>
                                    <th>Satuan:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->barang->satuan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->barang->kategori ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>IMEI 1:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->imei_1 ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>IMEI 2:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->imei_2 ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-6">
                            <table class="table table-borderless table-show mb-0">
                                <tr>
                                    <th>Jumlah Stok:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->jumlah_stok ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Garansi:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->garansi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Modal:</th>
                                </tr>
                                <tr>
                                    <td>Rp{{ $stock->modal ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Jual:</th>
                                </tr>
                                <tr>
                                    <td>Rp{{ $stock->harga_jual ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-6">
                            <table class="table table-borderless table-show mb-0">
                                <tr>
                                    <th>Invoice:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->invoice ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->tanggal ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Supplier:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->supplier ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No Kontak Supplier:</th>
                                </tr>
                                <tr>
                                    <td>{{ $stock->NoKontakSupplier ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div>
                        <table class="table table-borderless table-show mb-0">
                            <tr>
                                <th>Deskripsi:</th>
                            </tr>
                            <tr>
                                <td>{{ $stock->deskripsi ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex gap-3 justify-content-end mt-3">
                        @if (!Auth::user()->hasRole('owner'))
                            <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil" style="margin: -12px 2px 0 0; font-size: 18px;"></i>
                                <span>Edit</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
