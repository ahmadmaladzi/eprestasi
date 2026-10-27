<?php

namespace Database\Seeders;

use App\Models\Kesiswaan;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Kelas
        $this->call(KelasSeeder::class);

        // Tahun Ajaran
        $ajaranAktif = TahunAjaran::create(['tahun' => '2025/2026', 'status' => 'Aktif']);
        TahunAjaran::create(['tahun' => '2024/2025', 'status' => 'Tidak Aktif']);

        // Admin
        User::create([
            'nama' => 'Admin E-Prestasi',
            'email' => 'admin@eprestasi.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // Kesiswaan
        $userKesiswaan = User::create([
            'nama' => 'Budi Santoso, S.Pd',
            'email' => 'kesiswaan@eprestasi.com',
            'role' => 'kesiswaan',
            'password' => bcrypt('password'),
        ]);
        $kesiswaan = Kesiswaan::create([
            'id_user' => $userKesiswaan->id,
            'nama' => 'Budi Santoso, S.Pd',
            'nip' => '198501012010011001',
            'jabatan' => 'Wakil Kepala Sekolah Bidang Kesiswaan',
            'email' => 'kesiswaan@eprestasi.com',
        ]);

        // Siswa contoh
        $dataSiswa = [
            ['nama' => 'Ahmad Maladzi', 'nis' => '2324001', 'kelas' => 'XI', 'jurusan' => 'RPL'],
            ['nama' => 'Siti Nurhaliza', 'nis' => '2324002', 'kelas' => 'XI', 'jurusan' => 'RPL'],
            ['nama' => 'Rian Firmansyah', 'nis' => '2324003', 'kelas' => 'XI', 'jurusan' => 'TKJ'],
        ];

        $tingkatList = ['Sekolah', 'Kabupaten/Kota', 'Provinsi', 'Nasional'];
        $kategoriList = ['Akademik', 'Non Akademik', 'Kejuaraan'];
        $statusList = ['Belum', 'Disetujui', 'Ditolak'];

        foreach ($dataSiswa as $i => $s) {
            $user = User::create([
                'nama' => $s['nama'],
                'email' => $i === 0 ? 'siswa@eprestasi.com' : Str::slug($s['nama']) . '@eprestasi.com',
                'role' => 'siswa',
                'password' => bcrypt('password'),
            ]);

            $siswa = Siswa::create([
                'id_user' => $user->id,
                'nama' => $s['nama'],
                'nis' => $s['nis'],
                'kelas' => $s['kelas'],
                'jurusan' => $s['jurusan'],
                'email' => $user->email,
                'qr_code' => Str::slug($s['nama']) . '-' . ($i + 1),
            ]);

            foreach (range(1, 3) as $n) {
                $status = $statusList[array_rand($statusList)];

                Prestasi::create([
                    'id_siswa' => $siswa->id_siswa,
                    'id_ajaran' => $ajaranAktif->id_ajaran,
                    'id_kesiswaan' => $status !== 'Belum' ? $kesiswaan->id_kesiswaan : null,
                    'nama_prestasi' => "Juara $n Lomba Contoh Tahun 2025",
                    'penyelenggara' => 'Dinas Pendidikan Provinsi Jawa Barat',
                    'tingkat' => $tingkatList[array_rand($tingkatList)],
                    'tanggal' => now()->subMonths($n)->format('Y-m-d'),
                    'deskripsi' => 'Deskripsi singkat prestasi contoh untuk keperluan demo.',
                    'status' => $status,
                    'kategori' => $status === 'Disetujui' ? $kategoriList[array_rand($kategoriList)] : null,
                    'catatan' => $status === 'Ditolak' ? 'Sertifikat kurang jelas, mohon upload ulang.' : null,
                    'tanggal_verifikasi' => $status !== 'Belum' ? now()->subDays($n) : null,
                ]);
            }
        }
    }
}
