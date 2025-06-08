<?php

namespace App\Exports;

use App\Models\Penjualan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenjualanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $data;

    public function __construct(?Collection $data = null)
    {
        if ($data) {
            $this->data = $data;
        } else {
            $this->data = $this->defaultData();
        }
    }

    protected function defaultData()
    {
        $query = Penjualan::success()->latest()->with(['pelanggan', 'tokoCabang', 'stock.barang', 'user']);

        if (auth()->user()->hasRole('agen')) {
            $query->isAgent();
        }

        return $query->get();
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            '#',
            'Invoice',
            'Pelanggan',
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

    public function map($penjualan): array
    {
        static $loopIndex = 0;
        $loopIndex++;

        return [
            $loopIndex,
            $penjualan->invoice,
            $penjualan->pelanggan->nama_pelanggan ?? 'Tidak Ada',
            $penjualan->tokoCabang->nama_toko_cabang ?? 'Tidak Ada',
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

    public function styles(Worksheet $sheet)
    {
        $totalRows = $this->collection()->count() + 1;

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
