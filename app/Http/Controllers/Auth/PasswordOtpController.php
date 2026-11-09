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

class PasswordOtpController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Silakan masukkan email terlebih dahulu.',
            ]);
        }

        return view('auth.verify-otp', [
            'email' => $email,
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = $request->session()->get('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Sesi reset password sudah berakhir. Silakan ulangi.',
            ]);
        }

        $emailRateLimitKey = 'password-otp-verify:'.$email;
        $ipRateLimitKey = 'password-otp-verify:'.$email.'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($emailRateLimitKey, 5) || RateLimiter::tooManyAttempts($ipRateLimitKey, 5)) {
            $seconds = max(
                RateLimiter::availableIn($emailRateLimitKey),
                RateLimiter::availableIn($ipRateLimitKey)
            );

            return back()->withErrors([
                'otp' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (! $record || ! $record->created_at) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa. Silakan kirim ulang kode.',
            ]);
        }

        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return back()->withErrors([
                'otp' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang kode.',
            ]);
        }

        if (! Hash::check($request->input('otp'), $record->token)) {
            RateLimiter::hit($emailRateLimitKey, 600);
            RateLimiter::hit($ipRateLimitKey, 600);

            return back()->withErrors([
                'otp' => 'Kode OTP salah. Periksa kembali email kamu.',
            ]);
        }

        RateLimiter::clear($emailRateLimitKey);
        RateLimiter::clear($ipRateLimitKey);
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        $request->session()->forget('password_reset_email');
        $request->session()->put('password_reset_verified_email', $email);
        $request->session()->put('password_reset_verified_at', now()->timestamp);
        $request->session()->regenerate();

        return redirect()->route('password.reset')->with(
            'status',
            'Kode OTP berhasil diverifikasi. Silakan buat password baru.'
        );
    }

    public function resend(Request $request): RedirectResponse
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Sesi reset password sudah berakhir. Silakan ulangi.',
            ]);
        }

        $rateLimitKey = 'password-otp-send:'.$email.'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);

            return back()->withErrors([
                'otp' => "Terlalu banyak permintaan. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if ($record?->created_at) {
            $elapsed = now()->timestamp - Carbon::parse($record->created_at)->timestamp;

            if ($elapsed < 60) {
                $seconds = 60 - $elapsed;

                return back()->with('status', "Kode OTP baru bisa dikirim dalam {$seconds} detik.");
            }
        }

        RateLimiter::hit($rateLimitKey, 600);

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($email)])
            ->first();

        if (! $user) {
            return back()->with(
                'status',
                'Jika email terdaftar, kode OTP telah dikirim. Periksa inbox atau folder spam.'
            );
        }

        if (! app()->environment(['local', 'testing']) && in_array(config('mail.default'), ['log', 'array'], true)) {
            RateLimiter::clear($rateLimitKey);

            return back()->withErrors([
                'otp' => 'Layanan email belum dikonfigurasi. Hubungi administrator sekolah.',
            ]);
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

            return back()->withErrors([
                'otp' => 'Email OTP gagal dikirim. Periksa konfigurasi email atau coba lagi.',
            ]);
        }

        return back()->with('status', 'Kode OTP baru telah dikirim. Periksa inbox atau folder spam.');
    }
}
