<?php

namespace App\Mail;

use App\Models\TeamInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TeamInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;
    public $acceptUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(TeamInvitation $invitation)
    {
        $this->invitation = $invitation;
        
        // Generate signed URL for security
        $this->acceptUrl = URL::signedRoute('team.join', ['token' => $invitation->token]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitación a unirte al equipo de ' . $this->invitation->tenant->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.team-invitation',
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