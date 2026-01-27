<?php

namespace App\Concerns;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;

trait SelectsProducts
{
    #[Computed]
    public function products(): Collection
    {
        return Product::query()->orderBy('name')->get();
    }
}
