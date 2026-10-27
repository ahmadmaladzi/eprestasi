<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Kelas X (10)
        $kelasX = [
            ['AKL', 3],   // X AKL 1, X AKL 2, X AKL 3
            ['MPLB', 5],  // X MPLB 1 - 5
            ['DKV', 2],   // X DKV 1, X DKV 2
            ['PM', 3],    // X PM 1, X PM 2, X PM 3
            ['PPLG', 2],  // X PPLG 1, X PPLG 2
            ['TKJ', 1],   // X TKJ
        ];

        foreach ($kelasX as [$jurusan, $jumlahRombel]) {
            for ($rombel = 1; $rombel <= $jumlahRombel; $rombel++) {
                $namaKelas = $rombel === 1 && $jumlahRombel === 1 
                    ? "X {$jurusan}" 
                    : "X {$jurusan} {$rombel}";

                Kelas::create([
                    'nama_kelas' => $namaKelas,
                    'tingkat' => '10',
                    'jurusan' => $jurusan,
                    'status' => 'Aktif',
                ]);
            }
        }

        // Kelas XI (11)
        $kelasXI = [
            ['AKL', 3],   // XI AKL 1-3
            ['DKV', 2],   // XI DKV 1-2
            ['MP', 3],    // XI MP 1-3
            ['MLOG', 1],  // XI MLOG
            ['BR', 3],    // XI BR 1-3
            ['RPL', 2],   // XI RPL 1-2
            ['TKJ', 1],   // XI TKJ
        ];

        foreach ($kelasXI as [$jurusan, $jumlahRombel]) {
            for ($rombel = 1; $rombel <= $jumlahRombel; $rombel++) {
                $namaKelas = $rombel === 1 && $jumlahRombel === 1 
                    ? "XI {$jurusan}" 
                    : "XI {$jurusan} {$rombel}";

                Kelas::create([
                    'nama_kelas' => $namaKelas,
                    'tingkat' => '11',
                    'jurusan' => $jurusan,
                    'status' => 'Aktif',
                ]);
            }
        }

        // Kelas XII (12)
        $kelasXII = [
            ['AK', 4],    // XII AK 1-4
            ['BR', 2],    // XII BR 1-2
            ['DKV', 2],   // XII DKV 1-2
            ['MP', 3],    // XII MP 1-3
            ['MLOG', 1],  // XII MLOG
            ['RPL', 2],   // XII RPL 1-2
            ['TKJ', 1],   // XII TKJ
        ];

        foreach ($kelasXII as [$jurusan, $jumlahRombel]) {
            for ($rombel = 1; $rombel <= $jumlahRombel; $rombel++) {
                $namaKelas = $rombel === 1 && $jumlahRombel === 1 
                    ? "XII {$jurusan}" 
                    : "XII {$jurusan} {$rombel}";

                Kelas::create([
                    'nama_kelas' => $namaKelas,
                    'tingkat' => '12',
                    'jurusan' => $jurusan,
                    'status' => 'Aktif',
                ]);
            }
        }
    }
}
