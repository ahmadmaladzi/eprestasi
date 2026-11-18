<?php

namespace App\Exports;

use App\Exports\Sheets\DaftarPrestasiSheet;
use App\Exports\Sheets\RekapPrestasiSheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PrestasiExport implements WithMultipleSheets
{
    public function __construct(
        protected Collection $prestasi,
        protected string $subtitle,
        protected string $dicetak
    ) {}

    public function sheets(): array
    {
        return [
            new RekapPrestasiSheet($this->prestasi, $this->subtitle, $this->dicetak),
            new DaftarPrestasiSheet($this->prestasi, $this->subtitle, $this->dicetak),
        ];
    }
}
