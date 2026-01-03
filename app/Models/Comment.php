<?php

namespace App\Models;

use App\Contracts\HasFluxColor;
use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model implements HasFluxColor
{
    use HasFactory;

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

    public function render(): string
    {
        return $this->content;
    }

    public function getFluxColor(): string
    {
        return $this->visibility->getFluxColor();
    }
}
