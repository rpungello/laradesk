<?php

namespace App\Concerns;

use App\Enums\TicketType;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

trait SelectsTypes
{
    #[Computed]
    public function types(): Collection
    {
        return collect(TicketType::cases());
    }
}
