@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="card shadow-sm p-4">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="{{ $stock->getFirstMediaUrl('stocks') }}" class="img-fluid rounded" alt="Product Image">
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <!-- Kolom 1 -->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Kode Barang:</th>
                                    </tr>
                                    <tr>
                                        <td>{!! $stock->kode_barang !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Barang:</th>
                                    </tr>
                                    <tr>
                                        <td>{!! $stock->nama_barang !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Satuan:</th>
                                    </tr>
                                    <tr>
                                        <td>{!! $stock->satuan !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori:</th>
                                    </tr>
                                    <tr>
                                        <td>{!! $stock->kategori !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Grade:</th>
                                    </tr>
                                    <tr>
                                        <td>{!! $stock->grade !!}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Kolom 2 -->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>IMEI 1:</th>
                                    </tr>
                                    <tr>
                                        <td>{!! $stock->imei_1 !!}</td>
                                    </tr>
                                    <tr>
                                        <th>IMEI 2:</th>
                                    </tr>
                                    <tr>
                                        <td>{!! $stock->imei_2 !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Stok:</th>
                                    </tr>
                                    <tr>
                                        <td>{!! $stock->jumlah_stok !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Modal:</th>
                                    </tr>
                                    <tr>
                                        <td>Rp{!! $stock->modal !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga Jual:</th>
                                    </tr>
                                    <tr>
                                        <td>Rp. {!! $stock->harga_jual !!}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Kolom 3 -->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Invoice:</th>
                                    </tr>
                                    <tr>
                                        <td>Rp. {!! $stock->invoice !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Garansi:</th>
                                    </tr>
                                    <tr>
                                        <td>{!! $stock->garansi !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan:</th>
                                    </tr>
                                    <tr>
                                        <td>{!! $stock->keterangan !!}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            {{-- tombol kembali --}}
                            <a href="{{ route('stocks.index') }}" class="btn btn-secondary btn-md">
                                <i class="bi bi-arrow-left"></i>
                                <span>Kembali</span>
                            </a>

                            {{-- edit dan hapus plus icon --}}
                            <div class="d-flex gap-3">
                                <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning btn-md">
                                    <i class="bi bi-pencil"></i>
                                    <span>Edit</span>
                                </a>
                                <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-md">
                                        <i class="bi bi-trash"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
