<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use MailerSend\LaravelDriver\MailerSendTrait;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels, MailerSendTrait;

    public $hotel;

    /**
     * Create a new message instance.
     */
    public function __construct(public Order $order)
    {
        $this->hotel = $this->order->hotel;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            subject: "{$this->hotel->name} Order Confirmation",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        $this->mailersend(
            null,
            ['order-confirmation']
        );
        return new Content(
            view: 'email.order-confirmation',

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
