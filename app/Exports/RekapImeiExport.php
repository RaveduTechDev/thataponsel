<?php

namespace App\Exports;

use App\Models\JasaImei;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Support\Str;

class RekapImeiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * Filters for the export.
     *
     * @var array
     */
    protected $filters;

    /**
     * Create a new export instance.
     *
     * @param array $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = JasaImei::query();
        $query->success()->filter($this->filters);

        return $query->get();
    }

    /**
     * @return array
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
            'DP Server',
            'Sisa Server',
            'Profit',
            'Metode Pembayaran',
            'Supplier',
            'Agen',
            'Status',
            'Tanggal Transaksi',
            'Tanggal Selesai',
            'Keterangan',
        ];
    }

    /**
     * @param JasaImei $jasaImei
     * @return array
     */
    public function map($jasaImei): array
    {
        static $loopIndex = 0;
        $loopIndex++;

        return [
            $loopIndex,
            $jasaImei->pelanggan->nama_pelanggan ?? 'N/A',
            $jasaImei->tipe ?? 'N/A',
            $jasaImei->imei ?? 'N/A',
            $jasaImei->biaya ?? '0',
            $jasaImei->modal ?? '0',
            $jasaImei->dp_server ?? '0',
            $jasaImei->sisa_server ?? '0',
            $jasaImei->profit ?? 'N/A',
            Str::title(str_replace('-', '-', $jasaImei->metode_pembayaran)),
            $jasaImei->supplier ?? 'N/A',
            $jasaImei->user->name ?? 'N/A',
            ucfirst($jasaImei->status),
            \Carbon\Carbon::parse($jasaImei->tanggal)->isoFormat('D MMMM Y') ?? 'N/A',
            $jasaImei->updated_at->isoFormat('D MMMM Y') ?? 'N/A',
            $jasaImei->keterangan ?? 'N/A',
        ];
    }

    /**
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function styles(Worksheet $sheet)
    {
        $totalRows = $this->collection()->count() + 1;

        $sheet->getStyle('A1:P' . $totalRows)->getAlignment()->setWrapText(false);
        $sheet->getStyle('A1:P' . $totalRows)->getFont()->setName('Times New Roman');
        $sheet->getStyle('A1:P' . $totalRows)->getFont()->setSize(12);
        $sheet->getStyle('A1:P1')->getFont()->setBold(true);
        $sheet->getStyle('A1:P' . $totalRows)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A1:P' . $totalRows)->getAlignment()->setVertical('left');

        foreach (range('A', 'P') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }
}
