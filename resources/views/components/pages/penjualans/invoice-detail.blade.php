<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Thata Ponsel - Cetak Invoice </title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px
        }

        .header h1 {
            margin: 0;
            font-size: 24px
        }

        .info {
            margin-top: 5px;
            font-size: 14px
        }

        .customer,
        .items,
        .totals {
            margin-bottom: 20px
        }

        .customer .label {
            font-weight: bold
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left
        }

        table th {
            background: #f2f2f2
        }

        .totals table {
            width: 40%;
            float: right;
            border: none;
        }

        .totals th,
        .totals td {
            border: none;
            padding: 4px 8px;
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="container">
        @foreach ($data as $pelangganId => $penjualans)
            @php
                $first = $penjualans->first();
                $pelanggan = $first->pelanggan;
            @endphp

            {{-- Header Invoice --}}
            <div class="header">
                <h1>Invoice</h1>
                <div class="info">
                    <div>Tanggal Cetak: {{ now()->isoFormat('D MMMM YYYY') }}</div>
                    <div>No. Invoice: {{ $first->invoice }}</div>
                </div>
            </div>

            {{-- Data Pelanggan --}}
            <div class="customer">
                <p><span class="label">Nama:</span> {{ $pelanggan->nama_pelanggan }}</p>
                <p><span class="label">Alamat:</span> {{ $pelanggan->alamat ?? '-' }}</p>
                <p><span class="label">Telepon:</span> {{ $pelanggan->telepon ?? '-' }}</p>
            </div>

            <div class="items">
                <table>
                    <thead>
                        <tr>
                            <th style="width:5%;">#</th>
                            <th style="width:45%;">Nama Barang</th>
                            <th style="width:15%;">Qty</th>
                            <th style="width:15%;">Harga Satuan</th>
                            <th style="width:20%;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualans as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->stock->barang->nama_barang }}</td>
                                <td>{{ $item->qty ?? 1 }}</td>
                                <td>Rp {{ number_format($item->stock->harga_jual, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @php $grand = $penjualans->sum('total_bayar'); @endphp
            <div class="totals">
                <table>
                    <tr>
                        <th>Total:</th>
                        <td>Rp {{ number_format($grand, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach

        <div style="clear:both; text-align:center; font-size:10px; margin-top:50px;">
            <p>Terima kasih atas kepercayaan Anda. Hubungi kami di (021) 1234-5678 jika ada pertanyaan.</p>
        </div>
    </div>
</body>

</html>
