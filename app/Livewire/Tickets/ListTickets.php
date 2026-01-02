<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ListTickets extends Component
{
    public string $sortBy = 'priority';

    public string $sortDirection = 'asc';

    public function render(): View
    {
        return view('livewire.tickets.list-tickets');
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
        return Ticket::query()
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate();
    }
}
