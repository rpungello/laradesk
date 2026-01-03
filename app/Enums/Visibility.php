<?php

namespace App\Enums;

use App\Contracts\HasFluxColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

enum Visibility: string implements HasLabel, HasFluxColor
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
        return Str::title($this->name);
    }
}
