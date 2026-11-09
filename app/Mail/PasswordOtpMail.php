<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $otp,
        public int $expiresInMinutes = 10,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode OTP Reset Password E-Prestasi',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.password-otp',
        );
    }
}
