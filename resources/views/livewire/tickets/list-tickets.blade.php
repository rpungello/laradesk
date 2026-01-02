<div class="space=y-4">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item>@choice('model.ticket', 2)</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:table :paginate="$this->tickets">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'priority'" :direction="$sortDirection" wire:click="sort('priority')">
                @lang('ticket.priority')
            </flux:table.column>
            <flux:table.column>@lang('ticket.status')</flux:table.column>
            <flux:table.column>@lang('ticket.product_id')</flux:table.column>
            <flux:table.column>@lang('ticket.user_id')</flux:table.column>
            <flux:table.column>@lang('ticket.company_id')</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">
                @lang('ticket.created_at')
            </flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'updated_at'" :direction="$sortDirection" wire:click="sort('updated_at')">
                @lang('ticket.updated_at')
            </flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->tickets as $ticket)
                <flux:table.row>
                    <!-- Priority -->
                    <flux:table.cell>
                        <flux:badge size="sm"
                                    :color="$ticket->priority->getFluxColor()"
                        >
                            {{ $ticket->priority->getLabel() }}
                        </flux:badge>
                    </flux:table.cell>

                    <!-- Status -->
                    <flux:table.cell>
                        <flux:badge size="sm"
                                    :color="$ticket->status->getFluxColor()"
                        >
                            {{ $ticket->status->getLabel() }}
                        </flux:badge>
                    </flux:table.cell>

                    <!-- Product -->
                    <flux:table.cell>
                        {{ $ticket->product?->name }}
                    </flux:table.cell>

                    <!-- User -->
                    <flux:table.cell>
                        {{ $ticket->user->name }}
                    </flux:table.cell>

                    <!-- Company -->
                    <flux:table.cell>
                        {{ $ticket->company?->name }}
                    </flux:table.cell>

                    <!-- Requested At -->
                    <flux:table.cell>
                        {{ $ticket->created_at->diffForHumans() }}
                    </flux:table.cell>

                    <!-- Updated At -->
                    <flux:table.cell>
                        {{ $ticket->updated_at->diffForHumans() }}
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
