<?php

namespace App\Observers;

use App\Models\Comment;
use App\Notifications\CommentPostedNotification;
use Illuminate\Support\Facades\Notification;

class CommentObserver
{
    public function created(Comment $comment): void
    {
        Notification::send(
            $comment->getRecipients(),
            new CommentPostedNotification($comment)
        );
    }
}
