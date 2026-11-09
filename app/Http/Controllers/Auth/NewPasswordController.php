<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $email = $request->session()->get('password_reset_verified_email');
        $verifiedAt = $request->session()->get('password_reset_verified_at');

        if (! $email || ! $verifiedAt || now()->timestamp - $verifiedAt > 900) {
            $request->session()->forget([
                'password_reset_email',
                'password_reset_verified_email',
                'password_reset_verified_at',
            ]);

            return redirect()->route('password.request')->withErrors([
                'email' => 'Sesi reset password sudah berakhir. Silakan ulangi dari awal.',
            ]);
        }

        return view('auth.reset-password', [
            'email' => $email,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $email = $request->session()->get('password_reset_verified_email');
        $verifiedAt = $request->session()->get('password_reset_verified_at');

        if (! $email || ! $verifiedAt || now()->timestamp - $verifiedAt > 900) {
            $request->session()->forget([
                'password_reset_email',
                'password_reset_verified_email',
                'password_reset_verified_at',
            ]);

            return redirect()->route('password.request')->withErrors([
                'email' => 'Sesi reset password sudah berakhir. Silakan ulangi dari awal.',
            ]);
        }

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($email)])
            ->first();

        if (! $user) {
            $request->session()->forget([
                'password_reset_email',
                'password_reset_verified_email',
                'password_reset_verified_at',
            ]);

            return redirect()->route('password.request')->withErrors([
                'email' => 'Akun dengan email tersebut tidak ditemukan.',
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($request->input('password')),
            'remember_token' => Str::random(60),
        ])->save();

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        DB::table('sessions')->where('user_id', $user->id)->delete();

        event(new PasswordReset($user));

        $request->session()->forget([
            'password_reset_email',
            'password_reset_verified_email',
            'password_reset_verified_at',
        ]);
        $request->session()->regenerateToken();

        return redirect()->route('login')->with(
            'status',
            'Password berhasil diubah. Silakan masuk dengan password baru.'
        );
    }
}
