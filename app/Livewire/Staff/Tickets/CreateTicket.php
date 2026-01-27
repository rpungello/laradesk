<?php

namespace App\Livewire\Staff\Tickets;

use App\Concerns\SelectsCompanies;
use App\Concerns\SelectsPriorities;
use App\Concerns\SelectsProducts;
use App\Concerns\SelectsTypes;
use App\Concerns\SelectsUsers;
use App\Enums\Priority;
use App\Enums\TicketType;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateTicket extends Component
{
    use SelectsCompanies;
    use SelectsPriorities;
    use SelectsProducts;
    use SelectsTypes;
    use SelectsUsers;

    #[Validate(['required', 'min:3'])]
    public string $title = '';

    #[Validate(['required'])]
    public ?TicketType $type = null;

    #[Validate(['required', 'exists:users,id'])]
    public ?int $user_id = null;

    #[Validate(['nullable', 'exists:users,id'])]
    public ?int $assigned_user_id = null;

    #[Validate(['nullable', 'exists:products,id'])]
    public ?int $product_id = null;

    #[Validate(['nullable', 'exists:companies,id'])]
    public ?int $company_id = null;

    #[Validate(['required'])]
    public ?Priority $priority = null;

    #[Validate(['required', 'boolean'])]
    public bool $billable = false;

    #[Validate(['nullable', 'date'])]
    public ?Carbon $due_date = null;

    public function mount(): void
    {
        $this->assigned_user_id = auth()->id();
        $this->priority = Priority::Normal;
    }

    public function render(): View
    {
        return view('livewire.staff.tickets.create-ticket');
    }

    public function submit(): void
    {
        $this->redirectRoute(
            'staff.tickets.view',
            Ticket::create($this->validate())
        );
    }
}
