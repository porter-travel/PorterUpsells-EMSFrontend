<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Define the public property to store the data

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data; // Assign the data to the class property
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Contact Form Submission')
            ->html("
                <h1>New Contact Form Submission</h1>
                <p><strong>Name:</strong> {$this->data['name']}</p>
                <p><strong>Email:</strong> {$this->data['email']}</p>
                <p><strong>Company:</strong> {$this->data['company']}</p>
                <p><strong>Message:</strong></p>
                <p>{$this->data['message']}</p>
            ");
    }
}
