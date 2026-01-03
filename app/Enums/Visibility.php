<?php

namespace App\Enums;

use App\Contracts\HasDescription;
use App\Contracts\HasFluxColor;
use App\Contracts\HasFluxIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Visibility: string implements HasDescription, HasFluxColor, HasFluxIcon, HasLabel
{
    case Public = 'public';
    case Private = 'private';
    case StaffOnly = 'staff';

    public function getFluxColor(): string
    {
        return match ($this) {
            self::Public => 'gray',
            self::Private => 'red',
            self::StaffOnly => 'amber',
        };
    }

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Public => 'Public',
            self::Private => 'Private',
            self::StaffOnly => 'Staff Only',
        };
    }

    public function getFluxIcon(): string
    {
        return match ($this) {
            self::Public => 'eye',
            self::Private => 'lock-closed',
            self::StaffOnly => 'user-circle',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::Private => 'Only visible to you',
            self::StaffOnly => 'Only visible to staff members',
            self::Public => 'Visible to everyone',
        };
    }
}
