<?php

namespace App\Mail;

use App\Models\BbbEmpresa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class CustomerContactConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $customerData;
    public $empresa;
    public $locale;
    public $contactDate;

    /**
     * Create a new message instance.
     */
    public function __construct($customerData, BbbEmpresa $empresa, $locale = 'es')
    {
        $this->customerData = $customerData;
        $this->empresa = $empresa;
        $this->locale = $locale;
        $this->contactDate = now()->format('d/m/Y H:i');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $companyName = $this->empresa->nombre ?? 'BBB Páginas Web';
        
        return new Envelope(
            subject: "Confirmación de contacto - {$companyName}",
            from: new Address(
                $this->empresa->email ?? config('mail.from.address', config('app.support.email')),
                $this->empresa->nombre ?? config('mail.from.name', 'BBB Páginas Web')
            ),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-confirmation',
            with: [
                'customerName' => $this->customerData['name'],
                'customerEmail' => $this->customerData['email'],
                'customerPhone' => $this->customerData['phone'] ?? null,
                'customerCountry' => $this->customerData['country'],
                'customerPlan' => $this->customerData['plan'] ?? $this->customerData['plan_nombre'] ?? null,
                'customerMessage' => $this->customerData['message'] ?? $this->customerData['project_description'],
                'empresa' => $this->empresa,
                'contactDate' => $this->contactDate,
                'locale' => $this->locale,
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