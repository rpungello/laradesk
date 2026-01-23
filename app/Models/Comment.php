<?php

namespace App\Models;

use App\Contracts\HasFluxColor;
use App\Enums\Visibility;
use App\Observers\CommentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

#[ObservedBy([CommentObserver::class])]
class Comment extends Model implements Auditable, HasFluxColor
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'reply_to_comment_id',
        'visibility',
        'content',
    ];

    protected $casts = [
        'visibility' => Visibility::class,
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'reply_to_comment_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function getRecipients(): Collection
    {
        $recipients = $this->ticket->followers
            ->push($this->user)
            ->push($this->ticket->user);

        if (! empty($this->ticket->assignedUser)) {
            $recipients->push($this->ticket->assignedUser);
        }

        return $recipients->unique();
    }

    public function render(bool $displayImages = true, bool $includeSignature = false): string
    {
        $content = $this->content;

        if (! empty($this->reply_to_comment_id)) {
            $content = "<blockquote>{$this->replyTo->render(false)}</blockquote>$content";
        }

        // Grab all attachments for this comment once.
        $attachments = $this->attachments()
            ->orderBy('id')          // ensure a deterministic order
            ->get();

        if ($displayImages) {
            // Replace every [img:X] token with an <img> tag.
            $content = preg_replace_callback(
                '/\[img:(\d+)]/',
                function ($matches) use ($attachments) {
                    $index = (int) $matches[1];

                    // If the attachment exists, build the <img> element.
                    if (isset($attachments[$index])) {
                        /** @var Attachment $attachment */
                        $attachment = $attachments[$index];
                        $url = route('attachments.show', ['attachment' => $attachment, 'key' => $attachment->auth_key]);

                        return html()->a($url, html()->img($url)->class('max-w-xl'))->target('attachment');
                    }

                    // No attachment found – remove the placeholder (or return a fallback).
                    return '';
                },
                $content
            );
        }

        if ($includeSignature && ! empty($signature = $this->user->signatureForComment($this))) {
            $content .= "<br />$signature";
        }

        return $content;
    }

    public function getFluxColor(): string
    {
        return $this->visibility->getFluxColor();
    }

    public function generateTags(): array
    {
        return $this->ticket->generateTags();
    }
}
