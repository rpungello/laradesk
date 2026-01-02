<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum TicketType: string implements HasLabel
{
    case Task = 'task';

    case Question = 'question';

    case Quote = 'quote';

    case Incident = 'incident';

    case Problem = 'problem';

    public function getLabel(): string|Htmlable|null
    {
        return $this->name;
    }
}
