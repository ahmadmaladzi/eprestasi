<?php

namespace App\Exports\Concerns;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

trait StylesPrestasiSheet
{
    /**
     * Tulis blok judul (nama sekolah, judul laporan, periode, tanggal cetak).
     * Blok ini menempati baris 1-4, sedangkan header tabel ada di baris 6.
     */
    protected function writeTitleBlock(
        Worksheet $sheet,
        string $lastColumn,
        string $judul,
        string $subtitle,
        string $dicetak
    ): void {
        $sheet->mergeCells("A1:{$lastColumn}1");
        $sheet->setCellValue('A1', 'SMKN 11 BANDUNG');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF0B1E38']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(26);

        $sheet->mergeCells("A2:{$lastColumn}2");
        $sheet->setCellValue('A2', $judul);
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FF0B1E38']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->mergeCells("A3:{$lastColumn}3");
        $sheet->setCellValue('A3', $subtitle);
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['argb' => 'FF475569']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->mergeCells("A4:{$lastColumn}4");
        $sheet->setCellValue('A4', $dicetak);
        $sheet->getStyle('A4')->applyFromArray([
            'font' => ['size' => 9, 'italic' => true, 'color' => ['argb' => 'FF94A3B8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
    }

    /**
     * Gaya tabel: header gelap, border tipis, baris zebra, freeze pane, autofilter.
     */
    protected function styleTable(Worksheet $sheet, string $lastColumn, int $headerRow, int $lastRow): void
    {
        $sheet->getStyle("A{$headerRow}:{$lastColumn}{$headerRow}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 10, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF0B1E38']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);
        $sheet->getRowDimension($headerRow)->setRowHeight(28);

        $sheet->getStyle("A{$headerRow}:{$lastColumn}{$lastRow}")
            ->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->getColor()->setARGB('FFE2E8F0');

        for ($row = $headerRow + 1; $row <= $lastRow; $row++) {
            $sheet->getStyle("A{$row}:{$lastColumn}{$row}")
                ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            if (($row - $headerRow) % 2 === 0) {
                $sheet->getStyle("A{$row}:{$lastColumn}{$row}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
            }
        }

        $sheet->freezePane('A'.($headerRow + 1));

        if ($lastRow > $headerRow) {
            $sheet->setAutoFilter("A{$headerRow}:{$lastColumn}{$lastRow}");
        }
    }

    /**
     * @param  array<string, int>  $widths  [kolom => lebar]
     */
    protected function setColumnWidths(Worksheet $sheet, array $widths): void
    {
        foreach ($widths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
    }
}
