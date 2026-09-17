<?php

namespace App\Imports;

use App\Models\Kesiswaan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToCollection, WithHeadingRow
{
    public int $berhasil = 0;
    public array $gagal = []; // ['baris' => 2, 'pesan' => '...']

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $baris = $index + 2; // +2 karena baris 1 = header, index mulai dari 0

            $row = $row->map(fn ($v) => is_string($v) ? trim($v) : $v);

            $validator = Validator::make($row->toArray(), [
                'nama' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'role' => ['required', 'in:siswa,kesiswaan'],
                'password' => ['nullable', 'string', 'min:6'],
                'nis' => ['required_if:role,siswa', 'nullable', 'string', 'unique:siswa,nis'],
                'kelas' => ['required_if:role,siswa', 'nullable', 'string'],
                'jurusan' => ['required_if:role,siswa', 'nullable', 'string'],
                'nip' => ['required_if:role,kesiswaan', 'nullable', 'string', 'unique:kesiswaan,nip'],
                'jabatan' => ['nullable', 'string'],
                'no_hp' => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                $this->gagal[] = [
                    'baris' => $baris,
                    'pesan' => implode(' ', $validator->errors()->all()),
                ];
                continue;
            }

            $data = $validator->validated();
            $password = $data['password'] ?? 'password123'; // default kalau kolom password kosong

            $user = User::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => Hash::make($password),
            ]);

            if ($data['role'] === 'siswa') {
                Siswa::create([
                    'id_user' => $user->id,
                    'nama' => $data['nama'],
                    'nis' => $data['nis'],
                    'kelas' => $data['kelas'],
                    'jurusan' => $data['jurusan'],
                    'email' => $data['email'],
                    'no_hp' => $data['no_hp'] ?? null,
                ]);
            } else {
                Kesiswaan::create([
                    'id_user' => $user->id,
                    'nama' => $data['nama'],
                    'nip' => $data['nip'],
                    'jabatan' => $data['jabatan'] ?? null,
                    'no_hp' => $data['no_hp'] ?? null,
                    'email' => $data['email'],
                ]);
            }

            $this->berhasil++;
        }
    }
}