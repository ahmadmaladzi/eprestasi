<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordOtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Throwable;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower(trim((string) $request->input('email')));
        $rateLimitKey = 'password-otp-send:'.$email.'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);

            return back()->withInput()->withErrors([
                'email' => "Terlalu banyak permintaan. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        RateLimiter::hit($rateLimitKey, 600);

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->first();

        $sessionEmail = $user?->email ?? $email;
        $request->session()->put('password_reset_email', $sessionEmail);

        if ($user && ! app()->environment(['local', 'testing']) && in_array(config('mail.default'), ['log', 'array'], true)) {
            RateLimiter::clear($rateLimitKey);

            return back()->withInput()->withErrors([
                'email' => 'Layanan email belum dikonfigurasi. Hubungi administrator sekolah.',
            ]);
        }

        if ($user) {
            $existing = DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->first();

            // Jangan kirim ulang terlalu cepat. Tetap tampilkan pesan umum
            // supaya tidak membocorkan apakah email terdaftar atau tidak.
            if ($existing?->created_at) {
                $elapsed = now()->timestamp - Carbon::parse($existing->created_at)->timestamp;

                if ($elapsed < 60) {
                    return redirect()->route('password.otp')->with(
                        'status',
                        'Jika email terdaftar, kode OTP telah dikirim. Periksa inbox atau folder spam.'
                    );
                }
            }

            $otp = (string) random_int(100000, 999999);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                ['token' => Hash::make($otp), 'created_at' => now()]
            );

            try {
                Mail::to($user->email)->send(new PasswordOtpMail($user, $otp));
            } catch (Throwable $e) {
                report($e);

                DB::table('password_reset_tokens')->where('email', $user->email)->delete();
                RateLimiter::clear($rateLimitKey);

                return back()->withInput()->withErrors([
                    'email' => 'Email OTP gagal dikirim. Periksa konfigurasi email atau coba lagi.',
                ]);
            }
        }

        return redirect()->route('password.otp')->with(
            'status',
            'Jika email terdaftar, kode OTP telah dikirim. Periksa inbox atau folder spam.'
        );
    }
}
