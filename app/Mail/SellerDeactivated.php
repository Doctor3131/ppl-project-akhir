<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerDeactivated extends Mailable
{
    use Queueable, SerializesModels;

    public User $seller;
    public string $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(User $seller, string $reason = 'inactivity')
    {
        $this->seller = $seller;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[CAMPUSMARKET] Akun Toko Anda Telah Dinonaktifkan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.seller-deactivated',
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
