<?php

namespace App\Mail;

use App\Models\BbbEmpresa;
use App\Models\BbbLanding;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class LandingPublishedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public BbbEmpresa $empresa;
    public BbbLanding $landing;

    /**
     * Create a new message instance.
     */
    public function __construct(BbbEmpresa $empresa, BbbLanding $landing)
    {
        $this->empresa = $empresa;
        $this->landing = $landing;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            to: [new Address(config('app.support.email'), 'BBB Páginas Web')],
            subject: 'Nueva Landing Page Publicada - ' . $this->empresa->nombre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.landing-published',
            with: [
                'empresa' => $this->empresa,
                'landing' => $this->landing,
                'landingUrl' => $this->empresa->getLandingUrl(),
            ],
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