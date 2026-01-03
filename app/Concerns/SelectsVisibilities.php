<?php

namespace App\Concerns;

use App\Enums\Visibility;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

trait SelectsVisibilities
{
    #[Computed]
    public function visibilities(): Collection
    {
        return collect(Visibility::cases());
    }
}
