<?php

namespace App\Mail;

use App\Models\Hotel;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use MailerSend\LaravelDriver\MailerSendTrait;

class CustomerEmail extends Mailable
{
    use Queueable, SerializesModels, MailerSendTrait;

    public $subject = '';

    public $days = '';

    public $key_message = '';

    public $button_text = '';

    public $featured_products = [];

    public $additional_information = '';

    /**
     * Create a new message instance.
     */
    public function __construct(public Hotel $hotel, public $content)
    {
        //Calculate the number of days between now and the arrival date

        $arrivalDate = new \DateTime($content['arrival_date']);
        $days = (strtotime($content['arrival_date']) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
        $days == 1 ? $this->days = '1 day' : $this->days = $days . ' days';
        $this->subject = $content['guest_name'] . ', there’s just ' . $this->days . ' left to personalise your upcoming stay at ' . $hotel->name;

        $email_content = $hotel->hotelEmails->where('email_type', 'pre-arrival-email')->first();

        $this->key_message = nl2br($this->replacePlaceholders($email_content->key_message, $content, $hotel, $this->days));
        $this->button_text = $email_content->button_text;
        $this->featured_products = json_decode($email_content->featured_products);
        $this->additional_information = nl2br($this->replacePlaceholders($email_content->additional_information, $content, $hotel, $this->days));

        $tmp = [];
        foreach ($this->featured_products as $key => $product_id) {
            $tmp[] = Product::find($product_id);
        }
        $this->featured_products = $tmp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        if($this->hotel->id == 15){
            $sender = 'enquiries@riversideaymestrey.co.uk';
        } else {
            $sender = env('MAIL_FROM_ADDRESS');
        }
        return new Envelope(
            from: new Address( $sender,$this->hotel->name),
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        $this->mailersend(
            null,
            ['pre-arrival-email'],
        );
        return new Content(
            view: 'email.customer-email',
            with: ['hotel' => $this->hotel,
                'content' => $this->content,
                'days' => $this->days,
                'key_message' => $this->key_message,
                'button_text' => $this->button_text,
                'featured_products' => $this->featured_products,
                'additional_information' => $this->additional_information
            ]
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

    private function replacePlaceholders($template, $content, $hotel, $days)
    {
        // Define the placeholders and their replacements
        $placeholders = [
            '[guest_name]' => $content['guest_name'],
            '[hotel_name]' => $hotel->name,
            '[days_until_checkin]' => $days,
            '[hotel_email_address]' => $hotel->email_address,
        ];

        // Replace the placeholders with their values in the template
        return strtr($template, $placeholders);
    }

    private function nl2br_custom($string) {
        // Replace newlines with <br> tags
        return str_replace(["\r\n", "\n", "\r"], '<br>', $string);
    }
}
