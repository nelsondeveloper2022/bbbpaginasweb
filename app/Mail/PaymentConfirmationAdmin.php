<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\BbbRenovacion;

class PaymentConfirmationAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $renovacion;
    public $user;
    public $plan;

    /**
     * Create a new message instance.
     */
    public function __construct(BbbRenovacion $renovacion)
    {
        $this->renovacion = $renovacion;
        $this->user = $renovacion->user;
        $this->plan = $renovacion->plan;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.payment-confirmation-admin')
                    ->subject('💰 Nuevo Pago Recibido - BBB Páginas Web')
                    ->with([
                        'user' => $this->user,
                        'plan' => $this->plan,
                        'renovacion' => $this->renovacion,
                        'amount' => number_format($this->renovacion->amount, 0, ',', '.'),
                        'transactionId' => $this->renovacion->transaction_id,
                        'reference' => $this->renovacion->reference,
                        'paymentDate' => $this->renovacion->updated_at->format('d/m/Y H:i:s'),
                        'paymentMethod' => $this->renovacion->payment_method ?? 'No especificado',
                    ]);
    }
}