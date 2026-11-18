<?php

namespace App\Exports\Sheets;

use App\Exports\Concerns\StylesPrestasiSheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DaftarPrestasiSheet implements FromCollection, WithCustomStartCell, WithEvents, WithHeadings, WithStrictNullComparison, WithTitle
{
    use StylesPrestasiSheet;

    protected const HEADER_ROW = 6;

    private const LABEL_KATEGORI = [
        'Akademik' => 'Akademik',
        'Non Akademik' => 'Non-Akademik',
    ];

    public function __construct(
        protected Collection $prestasi,
        protected string $subtitle,
        protected string $dicetak
    ) {}

    public function title(): string
    {
        return 'Daftar Prestasi';
    }

    public function startCell(): string
    {
        return 'A'.self::HEADER_ROW;
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Nama Prestasi',
            'Kategori',
            'Tingkat',
            'Penyelenggara',
            'Tanggal',
        ];
    }

    public function collection(): Collection
    {
        return $this->prestasi->values()->map(function ($item, $index) {
            return [
                $index + 1,
                $item->siswa?->nis ?? '—',
                $item->siswa?->nama ?? '—',
                $item->siswa?->kelas ?? '—',
                $item->nama_prestasi,
                self::LABEL_KATEGORI[$item->kategori] ?? ($item->kategori ?: '—'),
                $item->tingkat ?: '—',
                $item->penyelenggara ?: '—',
                $item->tanggal?->format('d-m-Y') ?? '—',
            ];
        });
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = self::HEADER_ROW + $this->prestasi->count();

                $sheet->setShowGridLines(false);
                $this->writeTitleBlock(
                    $sheet,
                    'I',
                    'DAFTAR PRESTASI SISWA',
                    $this->subtitle,
                    $this->dicetak
                );
                $this->styleTable($sheet, 'I', self::HEADER_ROW, $lastRow);
                $this->setColumnWidths($sheet, [
                    'A' => 6,
                    'B' => 16,
                    'C' => 30,
                    'D' => 16,
                    'E' => 42,
                    'F' => 14,
                    'G' => 14,
                    'H' => 30,
                    'I' => 14,
                ]);

                $sheet->getStyle('A'.(self::HEADER_ROW + 1).':A'.$lastRow)
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I'.(self::HEADER_ROW + 1).':I'.$lastRow)
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Baris data lebih nyaman dibaca kalau agak tinggi.
                for ($row = self::HEADER_ROW + 1; $row <= $lastRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(20);
                }
            },
        ];
    }
}
