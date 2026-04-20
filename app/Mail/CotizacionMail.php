<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CotizacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva Solicitud de Cotización - ' . ($this->data['company'] ?? $this->data['name']),
            cc: ['vicman.corzo@gmail.com'],           // Copia visible
            bcc: ['c.augusto.espinoza@gmail.com']  // Copia oculta
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.cotizacion',
        );
    }
}