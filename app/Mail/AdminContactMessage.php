<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User; // Make sure to import the User model

class AdminContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subjectLine;
    public $userMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $subjectLine, $userMessage)
    {
        $this->user = $user;
        $this->subjectLine = $subjectLine;
        $this->userMessage = $userMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address($this->user->email, $this->user->name), // Sender will be the user
            subject: 'Mensagem de Contacto de Utilizador: ' . $this->subjectLine,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-contact-message', // Points to the Blade file
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
