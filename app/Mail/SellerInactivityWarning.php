<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerInactivityWarning extends Mailable
{
    use Queueable, SerializesModels;

    public User $seller;
    public int $daysUntilDeactivation;

    /**
     * Create a new message instance.
     */
    public function __construct(User $seller, int $daysUntilDeactivation = 7)
    {
        $this->seller = $seller;
        $this->daysUntilDeactivation = $daysUntilDeactivation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[CAMPUSMARKET] Peringatan: Akun Toko Anda Akan Dinonaktifkan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.seller-inactivity-warning',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
