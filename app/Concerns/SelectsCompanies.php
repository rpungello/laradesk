<?php

namespace App\Concerns;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;

trait SelectsCompanies
{
    #[Computed]
    public function companies(): Collection
    {
        return Company::query()->orderBy('name')->get();
    }
}
