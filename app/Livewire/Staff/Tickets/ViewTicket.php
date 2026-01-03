<?php

namespace App\Livewire\Staff\Tickets;

use App\Concerns\SelectsCompanies;
use App\Concerns\SelectsPriorities;
use App\Concerns\SelectsTypes;
use App\Concerns\SelectsUsers;
use App\Livewire\Forms\TicketForm;
use App\Models\Ticket;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ViewTicket extends Component
{
    use SelectsCompanies, SelectsPriorities, SelectsTypes, SelectsUsers;

    public Ticket $ticket;

    public TicketForm $form;

    public function mount(): void
    {
        $this->form->loadTicket($this->ticket);
    }

    public function render(): View
    {
        return view('livewire.staff.tickets.view-ticket');
    }

    public function save(): void
    {
        $this->ticket->update(
            $this->form->validate()
        );

        Flux::toast('Ticket updated', variant: 'success');
    }
}
