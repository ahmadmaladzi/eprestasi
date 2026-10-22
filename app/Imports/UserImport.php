<?php

namespace App\Imports;

use App\Models\Kesiswaan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToCollection, WithHeadingRow
{
    public int $berhasil = 0;
    public array $gagal = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $baris = $index + 2;

            $row = $row->map(function ($v) {
                if (is_null($v)) {
                    return null;
                }
                $v = is_string($v) ? trim($v) : (string) $v;
                return $v === '' ? null : $v;
            });

            $nama = $row->get('nama');
            $email = $row->get('email');
            $role = $row->get('role');

            if (empty($nama) && empty($email) && empty($role)) {
                continue;
            }

            $validator = Validator::make($row->toArray(), [
                'nama' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'role' => ['required', 'in:siswa,kesiswaan'],
                'password' => ['nullable', 'string', 'min:6'],
                'nis' => ['required_if:role,siswa', 'nullable', 'unique:siswa,nis'],
                'kelas' => ['required_if:role,siswa', 'nullable', 'string'],
                'jurusan' => ['required_if:role,siswa', 'nullable', 'string'],
                'nip' => ['required_if:role,kesiswaan', 'nullable', 'unique:kesiswaan,nip'],
                'jabatan' => ['nullable', 'string'],
                'no_hp' => ['nullable'],
            ]);

            if ($validator->fails()) {
                $this->gagal[] = [
                    'baris' => $baris,
                    'pesan' => implode(' ', $validator->errors()->all()),
                ];
                continue;
            }

            $data = $validator->validated();
            $password = $data['password'] ?? 'password123';

            $user = User::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => Hash::make($password),
            ]);

            if ($data['role'] === 'siswa') {
                // Generate qr_code unik: slug nama + kode acak, biar nggak nabrak satu sama lain
                $qrCode = Str::slug($data['nama']) . '-' . Str::random(6);

                Siswa::create([
                    'id_user' => $user->id,
                    'nama' => $data['nama'],
                    'nis' => (string) $data['nis'],
                    'kelas' => $data['kelas'],
                    'jurusan' => $data['jurusan'],
                    'email' => $data['email'],
                    'no_hp' => isset($data['no_hp']) ? (string) $data['no_hp'] : null,
                    'qr_code' => $qrCode,
                ]);
            } else {
                Kesiswaan::create([
                    'id_user' => $user->id,
                    'nama' => $data['nama'],
                    'nip' => (string) $data['nip'],
                    'jabatan' => $data['jabatan'] ?? null,
                    'no_hp' => isset($data['no_hp']) ? (string) $data['no_hp'] : null,
                    'email' => $data['email'],
                ]);
            }

            $this->berhasil++;
        }
    }
}