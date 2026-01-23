<?php

namespace App\Observers;

use App\Mail\CommentMail;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;

class CommentObserver
{
    public function created(Comment $comment): void
    {
        $mailable = new CommentMail($comment);
        $mailable->to($comment->getRecipients());
        Mail::queue($mailable);
    }
}
