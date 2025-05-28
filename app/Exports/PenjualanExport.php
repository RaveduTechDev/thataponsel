<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenjualanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Penjualan::success()->isAgent()->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Invoice',
            'Pelanggan',
            'Nomor WA',
            'Toko Cabang',
            'Agen',
            'Barang',
            'Qty',
            'Subtotal',
            'Diskon',
            'Total Bayar',
            'Metode Pembayaran',
            'Tanggal Transaksi',
            'Status',
        ];
    }

    /**
     * @param Penjualan $penjualan
     * @return array
     */
    public function map($penjualan): array
    {
        return [
            $penjualan->id,
            $penjualan->invoice,
            $penjualan->pelanggan->nama_pelanggan ?? 'Tidak Ada',
            $penjualan->pelanggan->nomor_wa ?? 'Tidak Ada',
            $penjualan->tokoCabang->nama_toko ?? 'Tidak Ada',
            $penjualan->user->name ?? 'Tidak Ada',
            $penjualan->stock->barang->nama_barang ?? 'Tidak Ada',
            $penjualan->qty,
            $penjualan->subtotal,
            $penjualan->diskon,
            $penjualan->total_bayar,
            $penjualan->metode_pembayaran,
            \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->isoFormat('D MMMM Y'),
            $penjualan->status,
        ];
    }

    /**
     * @return \Illuminate\Contracts\Support\Styler
     */
    public function styles(Worksheet $sheet)
    {
        $totalRows = count($this->collection()) + 1;
        $sheet->getStyle('A1:N' . $totalRows)->getAlignment()->setWrapText(false);
        $sheet->getStyle('A1:N' . $totalRows)->getFont()->setName('Times New Roman');
        $sheet->getStyle('A1:N' . $totalRows)->getFont()->setSize(12);
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N' . $totalRows)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A1:N' . $totalRows)->getAlignment()->setVertical('left');
        foreach (range('A', 'N') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }
}
