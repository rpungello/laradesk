<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;

trait SelectsUsers
{
    #[Computed]
    public function users(): Collection
    {
        return User::query()->orderBy('name')->get();
    }
}
