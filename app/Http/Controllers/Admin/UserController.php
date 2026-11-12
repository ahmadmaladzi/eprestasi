<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kesiswaan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter kelas untuk siswa (join ke tabel siswa)
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        // Filter status kelulusan untuk siswa
        if ($request->filled('status_kelulusan')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('status_kelulusan', $request->status_kelulusan);
            });
        }

        // Per halaman (dropdown control)
        $perPage = $request->filled('per_page') ? $request->per_page : 15;

        $users = $query->latest()->paginate($perPage)->withQueryString();

        $totalUser = User::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalKesiswaan = User::where('role', 'kesiswaan')->count();
        $totalAdmin = User::where('role', 'admin')->count();

        // Ambil distinct kelas untuk dropdown filter
        $kelasOptions = User::where('role', 'siswa')
            ->join('siswa', 'users.id', '=', 'siswa.id_user')
            ->distinct('siswa.kelas')
            ->orderBy('siswa.kelas')
            ->pluck('siswa.kelas');

        return view('admin.users.index', compact('users', 'totalUser', 'totalSiswa', 'totalKesiswaan', 'totalAdmin', 'kelasOptions'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'in:siswa,kesiswaan,admin'],
            'password' => ['required', 'string', 'min:8'],
            'nis' => ['required_if:role,siswa', 'nullable', 'string', 'unique:siswa,nis'],
            'kelas' => ['required_if:role,siswa', 'nullable', 'string'],
            'jurusan' => ['required_if:role,siswa', 'nullable', 'string'],
            'no_hp' => ['nullable', 'string'],
            'nip' => ['required_if:role,kesiswaan', 'nullable', 'string', 'unique:kesiswaan,nip'],
            'jabatan' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => bcrypt($validated['password']),
        ]);

        if ($validated['role'] === 'siswa') {
            Siswa::create([
                'id_user' => $user->id,
                'nama' => $validated['nama'],
                'nis' => $validated['nis'],
                'npsn' => '20219175',
                'kelas' => $validated['kelas'],
                'jurusan' => $validated['jurusan'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'] ?? null,
            ]);
        } elseif ($validated['role'] === 'kesiswaan') {
            Kesiswaan::create([
                'id_user' => $user->id,
                'nama' => $validated['nama'],
                'nip' => $validated['nip'],
                'jabatan' => $validated['jabatan'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'email' => $validated['email'],
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $siswa = $user->role === 'siswa' ? Siswa::where('id_user', $user->id)->first() : null;
        $kesiswaan = $user->role === 'kesiswaan' ? Kesiswaan::where('id_user', $user->id)->first() : null;

        return view('admin.users.edit', compact('user', 'siswa', 'kesiswaan'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'nis' => ['required_if:role,siswa', 'nullable', 'string', 'unique:siswa,nis,' . $user->id . ',id_user'],
            'kelas' => ['required_if:role,siswa', 'nullable', 'string'],
            'jurusan' => ['required_if:role,siswa', 'nullable', 'string'],
            'no_hp' => ['nullable', 'string'],
            'nip' => ['required_if:role,kesiswaan', 'nullable', 'string', 'unique:kesiswaan,nip,' . $user->id . ',id_user'],
            'jabatan' => ['nullable', 'string'],
        ]);

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();

        if ($user->role === 'siswa') {
            Siswa::where('id_user', $user->id)->update([
                'nama' => $validated['nama'],
                'nis' => $validated['nis'],
                'kelas' => $validated['kelas'],
                'jurusan' => $validated['jurusan'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'] ?? null,
            ]);
        } elseif ($user->role === 'kesiswaan') {
            Kesiswaan::where('id_user', $user->id)->update([
                'nama' => $validated['nama'],
                'nip' => $validated['nip'],
                'jabatan' => $validated['jabatan'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'email' => $validated['email'],
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Akun berhasil dihapus.');
    }

    public function importForm()
    {
        return view('admin.users.import');
    }

    public function import(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        $import = new \App\Imports\UserImport();
        \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('file'));

        $pesan = "{$import->berhasil} akun berhasil diimpor.";
        if (count($import->gagal) > 0) {
            $pesan .= ' ' . count($import->gagal) . ' baris gagal (lihat detail di bawah).';
        }

        return back()
            ->with($import->berhasil > 0 ? 'success' : 'error', $pesan)
            ->with('gagalImport', $import->gagal);
    }

    /**
     * Reset password user ke nilai default.
     */
    public function resetPassword(User $user)
    {
        // Password default: tanggal lahir siswa atau NIP untuk kesiswaan/admin
        $defaultPassword = match($user->role) {
            'siswa' => $user->siswa?->tanggal_lahir?->format('dmY') ?? '12345678',
            default => $user->kesiswaan?->nip ?? $user->email,
        };

        $user->password = bcrypt($defaultPassword);
        $user->save();

        return back()->with('success', "Password berhasil direset ke: {$defaultPassword}");
    }
}