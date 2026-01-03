<?php

namespace App\Models;

use App\Contracts\HasFluxColor;
use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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

    public function markdown(): string
    {
        return Str::markdown($this->content);
    }

    public function getFluxColor(): string
    {
        return $this->visibility->getFluxColor();
    }
}
