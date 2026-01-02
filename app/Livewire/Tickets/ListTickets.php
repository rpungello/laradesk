<?php

namespace App\Livewire\Tickets;

use App\Models\Company;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class ListTickets extends Component
{
    public string $search = '';

    #[Url]
    public string $product = '';

    #[Url]
    public string $user = '';

    #[Url]
    public string $assignee = '';

    #[Url]
    public string $company = '';

    public string $sortBy = 'priority';

    public string $sortDirection = 'asc';

    public function render(): View
    {
        return view('livewire.tickets.list-tickets');
    }

    public function submit(): void
    {
        // Do nothing
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function tickets(): LengthAwarePaginator
    {
        $builder = Ticket::search($this->search);

        if (! empty($this->product)) {
            $builder->where('product', $this->product);
        }

        if (! empty($this->user)) {
            $builder->where('user', $this->user);
        }

        if (! empty($this->assignee)) {
            $builder->where('assignee', $this->assignee);
        }

        if (! empty($this->company)) {
            $builder->where('company', $this->company);
        }

        return $builder->orderBy($this->sortBy, $this->sortDirection)->paginate();
    }

    #[Computed]
    public function products(): Collection
    {
        return Product::query()->orderBy('name')->get();
    }

    #[Computed]
    public function users(): Collection
    {
        return User::query()->orderBy('name')->get();
    }

    #[Computed]
    public function companies(): Collection
    {
        return Company::query()->orderBy('name')->get();
    }
}
