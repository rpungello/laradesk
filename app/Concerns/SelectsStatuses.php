<?php

namespace App\Concerns;

use App\Enums\TicketStatus;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

trait SelectsStatuses
{
    #[Computed]
    public function statuses(): Collection
    {
        return collect(TicketStatus::cases());
    }
}
