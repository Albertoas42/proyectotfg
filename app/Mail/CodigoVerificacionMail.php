<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodigoVerificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo; // Propiedad pública para que esté accesible en la plantilla

    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔒 Código de verificación - Segundaclase',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verification', // La vista blade del correo
        );
    }
}
