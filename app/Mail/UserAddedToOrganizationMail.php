<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Organization;
class UserAddedToOrganizationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $organization;
    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Organization $organization)
    {
        $this->user = $user;
        $this->organization = $organization;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . $this->organization->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: '
                <h1>Welcome to ' . $this->organization->name . '</h1>
                <p>Hi ' . $this->user->name . ',</p>
                <p>You have been added to the organization ' . $this->organization->name . '.</p>
                <p>We’re excited to have you on board!</p>
            '
        );
        
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            
        ];
    }
}
