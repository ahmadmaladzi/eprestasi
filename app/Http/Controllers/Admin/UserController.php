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

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
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
}