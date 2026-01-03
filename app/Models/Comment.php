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
class Comment extends Model implements HasFluxColor, Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'ticket_id',
        'user_id',
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

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function getRecipients(): Collection
    {
        return $this->ticket->followers
            ->push($this->user)
            ->push($this->ticket->user)
            ->push($this->ticket->assignedUser)
            ->unique();

    }

    public function render(): string
    {
        return $this->content;
    }

    public function getFluxColor(): string
    {
        return $this->visibility->getFluxColor();
    }
}
