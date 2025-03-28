@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <h2 class="text-danger">{{ $title }}</h2>
                    <a href={{ route('penjualan.index') }} style="margin:-8px 0 0 0;"
                        class="d-inline-flex align-items-center btn btn-secondary btn-md">
                        <span>Kembali</span>
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            {{-- detail penjualan lengkap --}}
                            <thead>
                                <tr>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Nama Pembeli</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Diskon</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>{{ $penjualan->invoice }}</tr>
                                <tr>{{ $penjualan->pelanggan->nama_pelanggan }}</tr>
                                <tr>{{ $penjualan->stock->barang->nama_barang }}</tr>
                                <tr>{{ $penjualan->jumlah }}</tr>
                                <tr>{{ $penjualan->subtotal }}</tr>
                                <tr>{{ $penjualan->diskon }}</tr>
                                <tr>{{ $penjualan->total_bayar }}</tr>
                                <tr>{{ $penjualan->created_at }}</tr> --}}
                                <tr>
                                    <td>{{ $penjualan->invoice }}</td>
                                    <td>{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                                    <td>{{ $penjualan->stock->barang->nama_barang }}</td>
                                    <td>{{ $penjualan->subtotal }}</td>
                                    <td>{{ $penjualan->diskon }}</td>
                                    <td>{{ $penjualan->total_bayar }}</td>
                                    <td>{{ $penjualan->created_at->format('d-m-Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
