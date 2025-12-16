<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderBukuTerlambat extends Mailable
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
            subject: '🚨Reminder Buku Terlambat Dikembalikan🚨',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.reminder-terlambat',
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
