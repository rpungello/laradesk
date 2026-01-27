<div class="flex flex-col space-y-4 h-full">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('staff.tickets.index')" wire:navigate>@choice('model.ticket', 2)</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>@lang('general.new')</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form wire:submit.prevent="submit" class="space-y-4 max-w-lg">
        <!-- Title -->
        <flux:input wire:model="title" :label="__('ticket.title')" />

        <!-- Type -->
        <flux:select wire:model="type" :label="__('ticket.type')" variant="listbox" clearable>
            @foreach($this->types as $type)
                <flux:select.option :value="$type->value" :label="$type->name" />
            @endforeach
        </flux:select>

        <!-- User -->
        <flux:select wire:model="user_id" :label="__('ticket.user_id')" variant="listbox" searchable clearable>
            @foreach($this->users as $user)
                <flux:select.option :value="$user->getKey()" :label="$user->name" />
            @endforeach
        </flux:select>

        <!-- Assigned User -->
        <flux:select wire:model="assigned_user_id" :label="__('ticket.assigned_user_id')" variant="listbox" searchable clearable>
            @foreach($this->users as $user)
                <flux:select.option :value="$user->getKey()" :label="$user->name" />
            @endforeach
        </flux:select>

        <!-- Product -->
        <flux:select wire:model="product_id" :label="__('ticket.product_id')" variant="listbox" clearable>
            @foreach($this->products as $product)
                <flux:select.option :value="$product->getKey()" :label="$product->name" />
            @endforeach
        </flux:select>

        <!-- Company -->
        <flux:select wire:model="company_id" :label="__('ticket.company_id')" variant="listbox" searchable clearable>
            @foreach($this->companies as $company)
                <flux:select.option :value="$company->getKey()" :label="$company->name" />
            @endforeach
        </flux:select>

        <!-- Billable -->
        <flux:checkbox wire:model="billable" :label="__('ticket.billable')" />

        <!-- Due Date -->
        <flux:date-picker wire:model="due_date" :label="__('ticket.due_date')" selectable-header />

        <flux:button type="submit" variant="primary">
            @lang('general.save')
        </flux:button>
    </form>
</div>
