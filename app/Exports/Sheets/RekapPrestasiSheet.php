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
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RekapPrestasiSheet implements FromCollection, WithCustomStartCell, WithEvents, WithHeadings, WithStrictNullComparison, WithTitle
{
    use StylesPrestasiSheet;

    protected const HEADER_ROW = 6;

    public function __construct(
        protected Collection $prestasi,
        protected string $subtitle,
        protected string $dicetak
    ) {}

    public function title(): string
    {
        return 'Rekap';
    }

    public function startCell(): string
    {
        return 'A'.self::HEADER_ROW;
    }

    public function headings(): array
    {
        return ['Kelas', 'Jumlah Siswa Berprestasi', 'Jumlah Prestasi'];
    }

    public function collection(): Collection
    {
        $rows = $this->prestasi
            ->groupBy(fn ($item) => $item->siswa?->kelas ?: 'Tanpa Kelas')
            ->sortKeys()
            ->map(fn (Collection $items, string $kelas) => [
                $kelas,
                $items->pluck('id_siswa')->unique()->count(),
                $items->count(),
            ])
            ->values();

        return $rows->push([
            'TOTAL',
            $this->prestasi->pluck('id_siswa')->unique()->count(),
            $this->prestasi->count(),
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = self::HEADER_ROW + $this->prestasi
                    ->groupBy(fn ($item) => $item->siswa?->kelas ?: 'Tanpa Kelas')
                    ->count() + 1;

                $sheet->setShowGridLines(false);
                $this->writeTitleBlock(
                    $sheet,
                    'C',
                    'REKAP PRESTASI SISWA',
                    $this->subtitle,
                    $this->dicetak
                );
                $this->styleTable($sheet, 'C', self::HEADER_ROW, $lastRow);
                $this->setColumnWidths($sheet, ['A' => 22, 'B' => 26, 'C' => 20]);

                // Baris TOTAL dibuat tebal.
                $sheet->getStyle("A{$lastRow}:C{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FF0B1E38']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFEEF4FF']],
                ]);

                // Angka rata kanan.
                $sheet->getStyle('B'.self::HEADER_ROW.':C'.$lastRow)
                    ->getAlignment()->setHorizontal('right');
            },
        ];
    }
}
