<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="icon" href="{{ public_path('logo-thata-png-col.png') }}" type="image/x-icon">

    <title>Thata Ponsel - Nota Transaksi</title>

    <style>
        /* ===== Reset & Font ===== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Trebuchet MS", Arial, sans-serif;
            padding: 20px;
            background-color: #f9f9f9;
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
            text-align: center;
            border-bottom: 2px solid #ececec;
            padding-bottom: 12px;
        }

        .invoice-header img {
            max-height: 60px;
            margin-bottom: 8px;
        }

        .invoice-header h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 8px;
        }

        .contact-info {
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

        .contact-info .alamat {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
        }

        /* ===== Info Pembeli ===== */
        .customer-info {
            font-size: 14px;
            color: #333;
        }

        .customer-info p {
            margin-top: 8px;
        }

        .customer-info strong {
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
            margin-left: 10px;
            font-size: 14px;
            color: #333;
            font-size: 14px;
        }

        .payment-method strong {
            color: #555;
        }

        /* ===== Catatan ===== */
        .notes {
            margin-top: 20px;
            margin-left: 10px;
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

            <div class="invoice-header">
                <h2>NOTA TRANSAKSI</h2>
                <img src="{{ public_path('logo-thata-png-col.png') }}" alt="Logo Perusahaan">
                <div class="contact-info">
                    <p class="alamat">Alamat: <strong>{{ $first->tokoCabang->alamat_toko ?? '-' }}</strong></p>
                    <p>Telp: <strong>0812-3456-7890</strong></p>
                    <p>Instagram:
                        <strong>
                            <a href="https://www.instagram.com/thataponselaceh/" target="_blank">@thataphonselaceh</a>
                        </strong>
                    </p>
                    <p>Tanggal:
                        <strong>{{ \Carbon\Carbon::parse($first->tanggal_transaksi)->isoFormat('D MMMM YYYY') }}</strong>
                    </p>
                </div>
            </div>

            <div class="items">
                <table>
                    <thead>
                        <tr>
                            <th style="white-space: nowrap;">#</th>
                            <th>Nama Barang</th>
                            <th style="white-space: nowrap;">Jumlah</th>
                            <th style="white-space: nowrap;">Harga Satuan</th>
                            <th style="white-space: nowrap;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualans as $i => $item)
                            <tr>
                                <td style="white-space: nowrap;">{{ $i + 1 }}</td>
                                <td>{{ $item->stock->barang->nama_barang }}</td>
                                <td style="white-space: nowrap;">{{ $item->qty ?? 1 }}</td>
                                <td style="white-space: nowrap;">
                                    Rp{{ number_format($item->stock->harga_jual, 0, ',', '.') }}</td>
                                <td style="white-space: nowrap;">
                                    Rp{{ number_format($item->total_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="total-label" style="font-weight: bold; text-align:left;">
                                Total:
                            </td>
                            <td colspan="2" class="total-label" style="font-weight: bold; text-align:left;">
                                {{ $penjualans->sum('qty') }}
                            </td>
                            <td style="white-space: nowrap; font-weight: bold; text-align:left;">
                                Rp{{ number_format($penjualans->sum('total_bayar'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>

            <div class="payment-method">
                <p><strong>Metode Pembayaran:</strong> {{ $first->metode_pembayaran ?? 'Tunai' }}</p>
                <div class="customer-info">
                    <p><strong>Nama Pembeli:</strong> {{ $pelanggan->nama_pelanggan }}</p>
                    <p><strong>No. HP Pembeli:</strong> {{ $pelanggan->nomor_wa_formatted ?? '-' }}</p>
                </div>
            </div>

            <div class="notes">
                <strong>Catatan:</strong>
                <ul>
                    <li>Barang yang sudah dibeli tidak dapat dikembalikan.</li>
                    <li>Harap simpan nota ini sebagai bukti transaksi.</li>
                </ul>
            </div>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach

        <div class="invoice-footer">
            <p>Terima kasih telah berbelanja di Thataphonselaceh!</p>
            <p>
                <i> Semoga puas dengan layanan kami</i>
                <img src="{{ public_path('static/img/hand.png') }}" style="transform: translateY(5px);" width="20"
                    alt="Logo Perusahaan">
            </p>
        </div>
    </div>
</body>

</html>
