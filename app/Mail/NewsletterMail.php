<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $asunto;
    public string $mensaje;
    public string $nombreSuscriptor;

    public function __construct(string $asunto, string $mensaje, string $nombreSuscriptor)
    {
        $this->asunto = $asunto;
        $this->mensaje = $mensaje;
        $this->nombreSuscriptor = $nombreSuscriptor;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->asunto,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter',
        );
    }
}