<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderPengembalianBuku3Hari extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $dataPeminjaman;

    public function __construct($dataPeminjaman)
    {
        $this->dataPeminjaman = $dataPeminjaman;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨Reminder Pengembalian Buku H-3 Hari🚨',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.reminder',
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
