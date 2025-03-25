@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Detail Penjualan</h1>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Detail Penjualan</h3>
                        <table class="table table-striped">
                            <tr>
                                <th>ID</th>
                                <td>{{ $penjualan->id }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ $penjualan->tanggal }}</td>
                            </tr>
                            <tr>
                                <th>Barang</th>
                                <td>{{ $penjualan->barang->nama_barang }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>{{ $penjualan->id }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>{{ $penjualan->total }}</td>
                            </tr>
                        </table>
                        <a href="{{ route('penjualan.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
