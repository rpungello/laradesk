<?php

namespace App\Enums;

use App\Contracts\HasFluxIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum UserRole: string implements HasColor, HasFluxIcon, HasLabel
{
    case Administrator = 'admin';
    case Staff = 'staff';
    case Client = 'client';

    public function getLabel(): string|Htmlable|null
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Administrator => 'danger',
            self::Staff => 'warning',
            self::Client => 'info',
        };
    }

    public function getFluxIcon(): string
    {
        return match ($this) {
            self::Administrator => 'lock-closed',
            self::Staff => 'headset',
            self::Client => '',
        };
    }
}
