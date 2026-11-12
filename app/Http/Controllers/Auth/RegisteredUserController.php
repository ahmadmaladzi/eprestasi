<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nis' => ['required', 'string', 'max:50', 'unique:siswa,nis'],
            'npsn' => ['required', 'string', 'max:50'],
            'kelas' => ['required', 'string', 'max:20'],
            'jurusan' => ['required', 'string', 'max:50'],
        ]);

        // Registrasi mandiri selalu jadi akun siswa.
        // Akun kesiswaan/admin tetap harus dibuatkan lewat panel Admin > Kelola Akun Pengguna.
        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'id_user' => $user->id,
            'nama' => $validated['nama'],
            'nis' => $validated['nis'],
            'npsn' => $validated['npsn'],
            'kelas' => $validated['kelas'],
            'jurusan' => $validated['jurusan'],
            'email' => $validated['email'],
            'qr_code' => Str::slug($validated['nama']) . '-' . Str::random(5),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
