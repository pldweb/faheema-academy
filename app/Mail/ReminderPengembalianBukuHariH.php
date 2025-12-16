<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderPengembalianBukuHariH extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $dataPeminjaman;

    public function __construct($dataPeminjaman)
    {
        $this->dataPeminjaman = $dataPeminjaman;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨Reminder Pengembalian Buku Hari Ini 🚨',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.reminder-hari-h',
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
