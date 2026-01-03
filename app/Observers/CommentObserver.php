<?php

namespace App\Observers;

use App\Mail\CommentMail;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;

class CommentObserver
{
    public function creating(Comment $comment): void
    {
        if (! empty($signature = $comment->user->signatureForComment($comment))) {
            $comment->content .= "<br>$signature";
        }
    }

    public function created(Comment $comment): void
    {
        $mailable = new CommentMail($comment);
        $mailable->to($comment->getRecipients());
        Mail::queue($mailable);
    }
}
