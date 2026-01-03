<?php

namespace App\Livewire\Forms;

use App\Enums\Priority;
use App\Enums\TicketStatus;
use App\Enums\TicketType;
use App\Models\Ticket;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TicketForm extends Form
{
    #[Validate(['required'])]
    public string $title = '';

    #[Validate(['required'])]
    public TicketStatus $status = TicketStatus::New;

    #[Validate(['required'])]
    public TicketType $type = TicketType::Task;

    #[Validate(['required', 'integer', 'exists:users,id'])]
    public ?int $user_id = null;

    #[Validate(['nullable', 'integer', 'exists:users,id'])]
    public ?int $assigned_user_id = null;

    #[Validate(['nullable', 'integer', 'exists:products,id'])]
    public ?int $product_id = null;

    #[Validate(['nullable', 'integer', 'exists:companies,id'])]
    public ?int $company_id = null;

    #[Validate(['required'])]
    public Priority $priority = Priority::Medium;

    #[Validate(['boolean'])]
    public bool $billable = false;

    #[Validate(['nullable', 'date'])]
    public ?Carbon $due_date = null;

    public function loadTicket(Ticket $ticket): void
    {
        $this->title = $ticket->title;
        $this->user_id = $ticket->user_id;
        $this->assigned_user_id = $ticket->assigned_user_id;
        $this->product_id = $ticket->product_id;
        $this->company_id = $ticket->company_id;
        $this->priority = $ticket->priority;
        $this->type = $ticket->type;
        $this->status = $ticket->status;
        $this->billable = $ticket->billable;
        $this->due_date = $ticket->due_date;
    }
}
