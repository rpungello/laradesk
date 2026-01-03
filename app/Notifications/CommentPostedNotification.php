<?php

namespace App\Notifications;

use App\Mail\CommentMail;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CommentPostedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Comment $comment) {}

    public function via($notifiable): array
    {
        return ['mail', 'broadcast'];
    }

    public function toMail($notifiable): Mailable
    {
        return (new CommentMail($this->comment))
            ->to($notifiable->email);
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->comment->toArray());
    }

    public function toArray($notifiable): array
    {
        return $this->comment->toArray();
    }
}
