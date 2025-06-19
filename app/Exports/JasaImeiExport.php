<?php

namespace App\Exports;

use App\Models\JasaImei;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Support\Str;

class JasaImeiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $data;

    public function __construct($data = null)
    {
        if ($data instanceof \Illuminate\Database\Eloquent\Collection) {
            $this->data = $data;
        } else {
            $this->data = $this->defaultData();
        }
    }

    protected function defaultData()
    {
        // if (auth()->user()->hasRole('agen')) {
        //     return JasaImei::success()
        //         ->isAgent(auth()->user()->role)
        //         ->latest()
        //         ->with(['pelanggan', 'user'])
        //         ->get();
        // }
        return JasaImei::success()
            ->isAdminImei()
            ->latest()
            ->with(['pelanggan', 'user'])
            ->get();
    }

    public function collection()
    {
        return $this->data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            '#',
            'Pelanggan',
            'Tipe',
            'IMEI',
            'Biaya',
            'Modal',
            'Profit',
            'Metode Pembayaran',
            'Supplier',
            'Admin',
            'Status',
            'Tanggal Transaksi',
            'Tanggal Selesai',
        ];
    }

    public function map($jasaImei): array
    {
        static $loopIndex = 0;
        $loopIndex++;

        return [
            $loopIndex,
            $jasaImei->pelanggan->nama_pelanggan ?? 'N/A',
            $jasaImei->tipe,
            $jasaImei->imei,
            $jasaImei->biaya,
            $jasaImei->modal,
            $jasaImei->profit,
            Str::title(str_replace('-', '-', $jasaImei->metode_pembayaran)),
            $jasaImei->supplier,
            $jasaImei->user->name ?? 'N/A',
            ucfirst($jasaImei->status),
            \Carbon\Carbon::parse($jasaImei->tanggal)->isoFormat('D MMMM Y') ?? 'N/A',
            $jasaImei->updated_at->isoFormat('D MMMM Y') ?? 'N/A',

        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalRows = $this->collection()->count() + 1;

        $sheet->getStyle('A1:M' . $totalRows)->getAlignment()->setWrapText(false);
        $sheet->getStyle('A1:M' . $totalRows)->getFont()->setName('Times New Roman');
        $sheet->getStyle('A1:M' . $totalRows)->getFont()->setSize(12);
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle('A1:M' . $totalRows)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A1:M' . $totalRows)->getAlignment()->setVertical('left');

        foreach (range('A', 'M') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }
}
