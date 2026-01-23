<?php

namespace App\Livewire\Staff\Tickets;

use App\Concerns\SelectsCompanies;
use App\Concerns\SelectsPriorities;
use App\Concerns\SelectsStatuses;
use App\Concerns\SelectsTypes;
use App\Concerns\SelectsUsers;
use App\Concerns\SelectsVisibilities;
use App\Enums\TicketStatus;
use App\Enums\Visibility;
use App\Livewire\Forms\TicketForm;
use App\Models\Comment;
use App\Models\Ticket;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ViewTicket extends Component
{
    use SelectsCompanies, SelectsPriorities, SelectsTypes, SelectsUsers, SelectsVisibilities, WithFileUploads, SelectsStatuses;

    public Ticket $ticket;

    public TicketForm $form;

    #[Validate(['required'])]
    public string $content = '';

    #[Validate(['required'])]
    public string $visibility;

    public ?Comment $replyingTo = null;

    #[Validate(['array'])]
    /**
     * @var TemporaryUploadedFile[]
     */
    public array $attachments = [];

    public array $followers = [];

    public function mount(): void
    {
        $this->visibility = Visibility::Public->value;
        $this->followers = $this->ticket->followers()->pluck('id')->toArray();
        $this->form->loadTicket($this->ticket);
    }

    public function render(): View
    {
        return view('livewire.staff.tickets.view-ticket');
    }

    public function save(): void
    {
        $this->ticket->update($this->form->validate());
        $this->ticket->followers()->sync($this->followers);

        Flux::toast('Ticket updated', variant: 'success');
    }

    public function replyTo(?Comment $comment): void
    {
        $this->replyingTo = $comment;
    }

    public function postComment(): void
    {
        $comment = $this->ticket->comments()->create(
            array_merge(
                ['user_id' => auth()->id(), 'reply_to_comment_id' => $this->replyingTo?->getKey()],
                Arr::only($this->validate(), ['visibility', 'content'])
            )
        );
        if ($this->ticket->status === TicketStatus::New) {
            $this->ticket->update(['status' => TicketStatus::Open]);
        }

        foreach ($this->attachments as $attachment) {
            $comment->attachments()->create([
                'disk' => config('filesystems.default'),
                'path' => $attachment->store('attachments'),
                'size' => $attachment->getSize(),
                'content_type' => $attachment->getMimeType(),
                'client_filename' => $attachment->getClientOriginalName(),
            ]);
        }
        $this->attachments = [];

        Flux::toast('Comment posted', variant: 'success');
        $this->content = '';
        $this->replyingTo = null;
    }

    public function removeAttachment(int $index): void
    {
        unset($this->attachments[$index]);
    }

    #[Computed]
    public function comments(): Collection
    {
        return $this->ticket->getVisibleComments(auth()->user());
    }
}
