<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public ContactMessage $contactMessage) {}

    public function envelope(): Envelope
    {
        $name = (string) $this->contactMessage->name;
        $service = (string) $this->contactMessage->service;
        $subject = 'New contact inquiry from '.$name.($service !== '' ? ' — '.$service : '');

        return new Envelope(
            subject: $subject,
            // Let the team hit "Reply" and reach the customer directly.
            replyTo: [new Address((string) $this->contactMessage->email, $name)],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.contact-message');
    }
}
