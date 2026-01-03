<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\TicketStatus;
use App\Enums\TicketType;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;

class Ticket extends Model implements Auditable
{
    use HasFactory, Searchable, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'title',
        'user_id',
        'assigned_user_id',
        'product_id',
        'company_id',
        'billable',
        'priority',
        'due_date',
        'type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getVisibleComments(User $user, $sortBy = 'created_at', $sortDirection = 'asc'): Collection
    {
        return $this
            ->comments()
            ->orderBy($sortBy, $sortDirection)
            ->get()
            ->filter(fn (Comment $comment) => $user->can('view', $comment));
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ticket_user', 'ticket_id', 'user_id');
    }

    public function emailSubject(string $suffix): string
    {
        return __('ticket.ticket_number', ['id' => $this->getKey()]).' - '.$suffix;
    }

    protected function casts(): array
    {
        return [
            'billable' => 'boolean',
            'due_date' => 'date',
            'priority' => Priority::class,
            'status' => TicketStatus::class,
            'type' => TicketType::class,
        ];
    }

    public function hasClientFollower(): bool
    {
        return $this->user->role === UserRole::Client
            || $this->followers()->whereRole(UserRole::Client)->exists();
    }

    public function generateTags(): array
    {
        return array_filter([
            $this->company?->name,
            $this->product?->name,
        ]);
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'user' => $this->user->name,
            'assignee' => $this->assignedUser?->name,
            'product' => $this->product?->name,
            'company' => $this->company?->name,
            'priority' => $this->priority->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
