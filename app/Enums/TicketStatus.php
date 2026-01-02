<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum TicketStatus: string implements HasLabel, HasColor
{
    case New = 'new';
    case Open = 'open';
    case Closed = 'closed';
    case Pending = 'pending';

    public function getLabel(): string|Htmlable|null
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::New => 'amber',
            self::Pending => 'blue',
            self::Closed => 'gray',
            self::Open => 'red',
        };
    }
}
