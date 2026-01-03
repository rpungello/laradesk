<?php

namespace App\Mail;

use App\Models\Attachment as AttachmentModel;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Comment $comment) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->comment->ticket->emailSubject(__('general.updated')),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.comment',
        );
    }

    public function attachments(): array
    {
        return $this->comment->attachments->map(
            fn (AttachmentModel $attachment) => Attachment::fromStorageDisk(
                $attachment->disk,
                $attachment->path
            )->as($attachment->client_filename)
        )->toArray();
    }
}
