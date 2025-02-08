@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Stok HP</h2>
            <a href={{ route('stocks.create') }} style="margin:-8px 0 0 0;"
                class="d-inline-flex align-items-center btn btn-success btn-md">
                <i class="bi bi-folder-plus" style="margin: -12px 8px 0 0; font-size: 18px;"></i>
                <span>Tambah Stock</span>
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive pt-2 pe-2">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th class="text-nowrap" data-orderable="false">Foto</th>
                                <th class="text-nowrap">Kode Barang</th>
                                <th class="text-nowrap">Nama Barang</th>
                                {{-- <th class="text-nowrap">Satuan</th> --}}
                                <th class="text-nowrap">Kategori</th>
                                {{-- <th class="text-nowrap">Grade</th>
                                <th class="text-nowrap">IMEI 1</th>
                                <th class="text-nowrap">IMEI 2</th> --}}
                                <th class="text-nowrap">Jumlah Stok</th>
                                {{-- <th class="text-nowrap">Modal</th> --}}
                                <th class="text-nowrap">Harga Jual</th>
                                {{-- <th class="text-nowrap">Invoice</th> --}}
                                <th class="text-nowrap">Supplier</th>
                                {{-- <th class="text-nowrap">No Kontak Supplier</th> --}}
                                <th class="text-nowrap">Tanggal</th>
                                {{-- <th class="text-nowrap">Keterangan</th> --}}
                                <th class="text-nowrap text-center" data-orderable="false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td class="text-nowrap">
                                        {{ $stock->foto }}
                                        {{-- <img src="{{ asset('storage/' . $stock->foto) }}" alt={{ $stock->nama_barang }}
                                            class="img-thumbnail" width="100" loading="lazy"> --}}
                                    </td>
                                    <td class="text-nowrap">{{ $stock->kode_barang }}</td>
                                    <td class="text-nowrap">{{ $stock->nama_barang }}</td>
                                    {{-- <td class="text-nowrap">{{ $stock->satuan }}</td> --}}
                                    <td class="text-nowrap">{{ $stock->kategori }}</td>
                                    {{-- <td class="text-nowrap">{{ $stock->grade }}</td>
                                    <td class="text-nowrap">{{ $stock->imei_1 }}</td>
                                    <td class="text-nowrap">{{ $stock->imei_2 }}</td> --}}
                                    <td class="text-nowrap">{{ $stock->jumlah_stok }}</td>
                                    {{-- <td class="text-nowrap">{{ $stock->modal }}</td> --}}
                                    <td class="text-nowrap">{{ $stock->harga_jual }}</td>
                                    {{-- <td class="text-nowrap">{{ $stock->invoice }}</td> --}}
                                    <td class="text-nowrap">{{ $stock->supplier }}</td>
                                    {{-- <td class="text-nowrap">{{ $stock->no_kontak_supplier }}</td> --}}
                                    <td class="text-nowrap">{{ $stock->tanggal }}</td>
                                    {{-- <td class="text-nowrap">{{ $stock->keterangan }}</td> --}}
                                    <td class="d-inline-flex">
                                        <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
