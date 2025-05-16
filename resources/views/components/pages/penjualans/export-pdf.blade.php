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
    {{-- $penjualans --}}

    <div class="container">
        <div class="items">
            <h2>Detail Penjualan</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualans->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->id->count() }}</td>
                            <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td>{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            <h2>Total Pembayaran</h2>
            <table>
                <tr>
                    <th>Total:</th>
                    <td>{{ number_format($penjualans->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if ($penjualans->diskon > 0)
                    <tr>
                        <th>Diskon:</th>
                        <td>{{ number_format($penjualans->diskon, 0, ',', '.') }}</td>
                    </tr>
                @endif

                <tr>
                    <th>Total Bayar:</th>
                    <td>{{ number_format($penjualans->total_bayar, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="page-break"></div>

</body>

</html>
