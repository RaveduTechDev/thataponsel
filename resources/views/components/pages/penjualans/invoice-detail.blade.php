<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Thata Ponsel - Cetak Invoice </title>

    <style>
        /* ===== Reset & Font ===== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Trebuchet MS", Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        /* ===== Container ===== */
        .invoice-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #fff;
            padding: 24px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* ===== Header ===== */
        .invoice-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #ececec;
            padding-bottom: 12px;
        }

        .invoice-header img {
            max-height: 60px;
        }

        .invoice-header h2 {
            font-size: 24px;
            color: #333;
            flex: 1;
            text-align: center;
        }

        .contact-info {
            text-align: right;
            font-size: 12px;
            color: #555;
        }

        .contact-info a {
            color: #007bff;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        /* ===== Info Pembeli & Transaksi ===== */
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }

        .invoice-details .left,
        .invoice-details .right {
            width: 48%;
        }

        .invoice-details p {
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .invoice-details strong {
            color: #555;
        }

        /* ===== Tabel Produk ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            font-size: 14px;
            color: #333;
        }

        table thead {
            background-color: #f0f0f0;
        }

        table thead th {
            padding: 10px;
            border-bottom: 2px solid #ddd;
            text-align: left;
        }

        table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        table tbody td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        tfoot tr td {
            padding: 10px;
            font-weight: bold;
            border-top: 2px solid #ddd;
        }

        tfoot tr td.total-label {
            text-align: right;
            padding-right: 16px;
        }

        /* ===== Metode Pembayaran ===== */
        .payment-method {
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }

        .payment-method strong {
            color: #555;
        }

        /* ===== Catatan ===== */
        .notes {
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }

        .notes strong {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        .notes ul {
            list-style: disc inside;
            margin-left: 16px;
        }

        .notes ul li {
            margin-bottom: 6px;
            line-height: 1.4;
        }

        /* ===== Footer ===== */
        .invoice-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #ececec;
            padding-top: 12px;
        }

        .invoice-footer p {
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        @foreach ($data as $pelangganId => $penjualans)
            @php
                $first = $penjualans->first();
                $pelanggan = $first->pelanggan;
            @endphp

            {{-- <div class="header">
                <h1 style="color: #4335dc">Nota Transaksi</h1>
                <img src="{{ public_path('logo-thata-png-col.png') }}" alt="" class="logo">
                <div class="info">
                    <div>Alamat Toko: {{ $first->tokoCabang->alamat_toko }}</div>
                    <div>Tanggal Cetak: {{ now()->isoFormat('D MMMM YYYY') }}</div>
                    <div>No. Invoice: {{ $first->invoice }}</div>
                </div>
            </div> --}}

            <div class="invoice-header">
                <img src="{{ public_path('logo-thata-png-col.png') }}" alt="Logo Perusahaan">
                <h2>NOTA TRANSAKSI</h2>
                <div class="contact-info">
                    <p>Telp: <strong>0812-3456-7890</strong></p>
                    <p>Instagram:
                        <strong>
                            <a href="https://www.instagram.com/thataponselaceh/" target="_blank">@thataphonselaceh</a>
                        </strong>
                    </p>
                </div>
            </div>


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
