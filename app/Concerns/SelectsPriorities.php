<?php

namespace App\Concerns;

use App\Enums\Priority;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

trait SelectsPriorities
{
    #[Computed]
    public function priorities(): Collection
    {
        return collect(Priority::cases())
            ->sort(fn (Priority $a, Priority $b) => $b->value - $a->value);
    }
}
