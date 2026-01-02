<?php

namespace App\Enums;

use App\Contracts\HasFluxColor;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum TicketStatus: string implements HasColor, HasFluxColor, HasLabel
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
            self::New => 'warning',
            self::Pending => 'info',
            self::Open => 'danger',
            default => null,
        };
    }

    public function getFluxColor(): string
    {
        return match ($this) {
            self::New => 'amber',
            self::Pending => 'blue',
            self::Closed => 'gray',
            self::Open => 'red',
        };
    }
}
