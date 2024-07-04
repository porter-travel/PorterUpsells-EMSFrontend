<?php

namespace App\Mail;

use App\Models\Hotel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = '';

    /**
     * Create a new message instance.
     */
    public function __construct(public Hotel $hotel, public $content)
    {
        //Calculate the number of days between now and the arrival date

        $arrivalDate = new \DateTime($content['arrival_date']);
        $now = new \DateTime();
        $interval = $now->diff($arrivalDate);
        $days = $interval->format('%a');
//        dd($days);
        $days = $days == 1 ? ' 1 day' : ' ' . $days . ' days';
        $this->subject = $content['guest_name'] . ', there’s just ' .  $days . ' left to personalise your upcoming stay at ' . $hotel->name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.customer-email',
            with: ['hotel' => $this->hotel, 'content' => $this->content]
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
