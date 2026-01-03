<div class="flex flex-col space-y-4 h-full">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item>@choice('model.ticket', 2)</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-row w-full gap-8 items-stretch flex-grow">
        <!-- Search Bar -->
        <aside class="min-w-xs">
            <form wire:submit.prevent="submit" class="flex flex-col space-y-4 h-full">
                <!-- General Search -->
                <flux:input
                    wire:model="search"
                    :label="__('general.search')"
                />

                <!-- Product -->
                <flux:select
                    wire:model="product"
                    variant="listbox"
                    searchable
                    clearable
                    :label="trans_choice('model.product', 1)"
                >
                    @foreach($this->products as $product)
                        <flux:select.option :label="$product->name"/>
                    @endforeach
                </flux:select>

                <!-- User -->
                <flux:select
                    wire:model="user"
                    variant="listbox"
                    searchable
                    clearable
                    :label="__('ticket.user_id')"
                >
                    @foreach($this->users as $user)
                        <flux:select.option :label="$user->name"/>
                    @endforeach
                </flux:select>

                <!-- Assignee -->
                <flux:select
                    wire:model="assignee"
                    variant="listbox"
                    searchable
                    clearable
                    :label="__('ticket.assigned_user_id')"
                >
                    @foreach($this->users as $user)
                        <flux:select.option :label="$user->name"/>
                    @endforeach
                </flux:select>

                <!-- Company -->
                <flux:select
                    wire:model="company"
                    variant="listbox"
                    searchable
                    clearable
                    :label="__('ticket.company_id')"
                >
                    @foreach($this->companies as $company)
                        <flux:select.option :label="$company->name"/>
                    @endforeach
                </flux:select>

                <div class="flex-grow"></div>

                <flux:button variant="primary" type="submit">
                    @lang('general.submit')
                </flux:button>
            </form>
        </aside>
        <flux:separator :vertical="true"/>
        <main class="flex-grow">
            <flux:table :paginate="$this->tickets">
                <flux:table.columns>
                    <flux:table.column sortable :sorted="$sortBy === 'priority'" :direction="$sortDirection" wire:click="sort('priority')">
                        @lang('ticket.priority')
                    </flux:table.column>
                    <flux:table.column>@lang('ticket.status')</flux:table.column>
                    <flux:table.column>@lang('ticket.title')</flux:table.column>
                    <flux:table.column>@lang('ticket.product_id')</flux:table.column>
                    <flux:table.column>@lang('ticket.user_id')</flux:table.column>
                    <flux:table.column>@lang('ticket.company_id')</flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">
                        @lang('ticket.created_at')
                    </flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'updated_at'" :direction="$sortDirection" wire:click="sort('updated_at')">
                        @lang('ticket.updated_at')
                    </flux:table.column>
                    <flux:table.column>
                        @lang('general.actions')
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

                            <!-- Title -->
                            <flux:table.cell>
                                {{ $ticket->title }}
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

                            <!-- Actions -->
                            @can('update', $ticket)
                                <flux:table.cell>
                                    <flux:button
                                        :href="route('staff.tickets.view', $ticket)"
                                        icon="eye"
                                        size="sm"
                                        variant="primary"
                                        wire:navigate
                                    />
                                </flux:table.cell>
                            @endcan
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </main>
    </div>
</div>
