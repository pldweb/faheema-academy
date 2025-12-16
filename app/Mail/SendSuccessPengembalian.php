<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendSuccessPengembalian extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public $bukuKembali;

    public function __construct($user, $bukuKembali)
    {
        $this->user = $user;
        $this->bukuKembali = $bukuKembali;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨Berhasil Kembalikan Buku🚨',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.success-kembalikan-buku',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
