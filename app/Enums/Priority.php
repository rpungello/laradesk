<?php

namespace App\Enums;

use App\Contracts\HasFluxColor;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Priority: int implements HasColor, HasFluxColor, HasLabel
{
    case Emergency = 1;

    case Critical = 2;

    case High = 3;

    case Medium = 4;

    case Low = 5;

    public function getLabel(): string|Htmlable|null
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match (true) {
            $this->value <= self::Critical->value => 'danger',
            $this === self::High => 'warning',
            $this === self::Medium => 'info',
            $this === self::Low => 'success',
        };
    }

    public function getFluxColor(): string
    {
        return match (true) {
            $this->value <= self::Critical->value => 'red',
            $this === self::High => 'amber',
            $this === self::Medium => 'blue',
            $this === self::Low => 'green',
        };
    }
}
