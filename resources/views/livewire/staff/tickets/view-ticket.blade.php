<div class="flex flex-col space-y-4">
    <flux:breadcrumbs class="flex-none">
        <flux:breadcrumbs.item :href="route('staff.tickets.index')" wire:navigate>@choice('model.ticket', 2)</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $ticket->title }} (#{{ $ticket->getKey() }})</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-row w-full gap-8 items-stretch flex-grow max-h-[calc(100vh-7rem)]">
        <aside>
            <form class="flex flex-col space-y-4 h-full min-w-xs" wire:submit.prevent="save">
                <flux:input
                    wire:model="form.title"
                    :label="__('ticket.title')"
                />

                <!-- Requesting User -->
                <flux:select variant="listbox" searchable wire:model="form.user_id" :label="__('ticket.user_id')">
                    @foreach($this->users as $user)
                        <flux:select.option :value="$user->getKey()">
                            <div class="flex items-center gap-2">
                                <span>{{ $user->name }}</span>
                                @if(! empty($icon = $user->role->getFluxIcon()))
                                    <flux:icon :name="$icon" variant="mini" />
                                @endif
                            </div>
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <!-- Followers -->
                <flux:pillbox wire:model="followers" :label="__('ticket.followers')" multiple searchable>
                    @foreach($this->users as $user)
                        <flux:pillbox.option :value="$user->getKey()">
                            <div class="flex items-center gap-2">
                                <span>{{ $user->name }}</span>
                                @if(! empty($icon = $user->role->getFluxIcon()))
                                    <flux:icon :name="$icon" variant="mini"/>
                                @endif
                            </div>
                        </flux:pillbox.option>
                    @endforeach
                </flux:pillbox>

                <!-- Assigned User -->
                <flux:select variant="listbox" searchable wire:model="form.assigned_user_id" :label="__('ticket.assigned_user_id')">
                    @foreach($this->users as $user)
                        <flux:select.option
                            :label="$user->name"
                            :value="$user->getKey()"
                        />
                    @endforeach
                </flux:select>

                <!-- Company -->
                <flux:select variant="listbox" searchable clearable wire:model="form.company_id" :label="__('ticket.company_id')">
                    @foreach($this->companies as $company)
                        <flux:select.option
                            :label="$company->name"
                            :value="$company->getKey()"
                        />
                    @endforeach
                </flux:select>

                <!-- Billable -->
                <flux:checkbox wire:model="form.billable" :label="__('ticket.billable')"/>

                <!-- Priority -->
                <flux:select wire:model="form.priority" :label="__('ticket.priority')">
                    @foreach($this->priorities as $priority)
                        <flux:select.option
                            :value="$priority->value"
                            :label="$priority->getLabel()"
                        />
                    @endforeach
                </flux:select>

                <!-- Type -->
                <flux:select wire:model="form.type" :label="__('ticket.type')">
                    @foreach($this->types as $type)
                        <flux:select.option
                            :value="$type->value"
                            :label="$type->getLabel()"
                        />
                    @endforeach
                </flux:select>

                <!-- Due Date -->
                <flux:date-picker
                    wire:model="form.due_date"
                    :label="__('ticket.due_date')"
                    clearable
                />

                <div class="flex-grow"></div>

                <flux:button variant="primary" type="submit">
                    @lang('general.save')
                </flux:button>
            </form>
        </aside>
        <flux:separator :vertical="true"/>
        <main class="flex-1 flex flex-col gap-4 overflow-y-scroll">
            @foreach($this->comments as $comment)
                <flux:callout :color="$comment->getFluxColor()">
                    <flux:callout.heading :icon="$comment->user->role === \App\Enums\UserRole::Client ? 'user-circle' : 'headset'">
                        <flux:text variant="strong">{{ $comment->user->name }}</flux:text>
                        <flux:text variant="subtle">{{ $comment->created_at->diffForHumans() }}</flux:text>
                    </flux:callout.heading>
                    <flux:separator />
                    <div class="ticket-body">
                        {!! $comment->render() !!}
                    </div>
                    @if($comment->attachments()->exists())
                        <x-slot:actions>
                            @foreach($comment->attachments as $attachment)
                                <flux:button
                                    size="xs"
                                    :href="route('attachments.show', ['attachment' => $attachment, 'key' => $attachment->auth_key])"
                                >
                                    {{ $attachment->client_filename }}
                                </flux:button>
                            @endforeach
                        </x-slot:actions>
                    @endif
                </flux:callout>
            @endforeach

            <!-- New Comment -->
            <flux:separator :text="__('general.new')" />
            <form wire:submit.prevent="postComment" class="space-y-4">
                <!-- New Comment Visibility -->
                <flux:radio.group wire:model.live="visibility" variant="cards" :label="__('comment.visibility')">
                    @foreach($this->visibilities as $visibility)
                        <flux:radio
                            :label="$visibility->getLabel()"
                            :icon="$visibility->getFluxIcon()"
                            :value="$visibility->value"
                            :description="$visibility->getDescription()"
                            :indicator="false"
                        />
                    @endforeach
                </flux:radio.group>

                <!-- New Comment Visibility Warning -->
                @if($ticket->hasClientFollower() && $this->visibility === \App\Enums\Visibility::Public->value)
                    <flux:callout variant="warning">
                        <flux:callout.heading>@lang('ticket.external')</flux:callout.heading>
                        <flux:callout.text>@lang('ticket.has_client_follower')</flux:callout.text>
                    </flux:callout>
                @endif

                <!-- New Comment Editor -->
                <flux:editor
                    wire:model="content"
                    :label="trans_choice('model.comment', 1)"
                    wire:keydown.prevent.cmd.enter="postComment"
                />

                <!-- New Comment Attachments -->
                <flux:file-upload wire:model="attachments" :label="__('ticket.attachments')">
                    <flux:file-upload.dropzone
                        heading="Drop files to attach"
                        text="Max size: 50MiB"
                        with-progress
                        inline
                    />
                </flux:file-upload>
                <div>
                    @foreach($attachments as $index => $attachment)
                        <flux:file-item :heading="$attachment->getClientOriginalName()">
                            <x-slot name="actions">
                                <flux:file-item.remove wire:click="removeAttachment({{ $index }})" />
                            </x-slot>
                        </flux:file-item>
                    @endforeach
                </div>
                <flux:button variant="primary" type="submit">
                    @lang('general.post')
                </flux:button>
            </form>
        </main>
    </div>
</div>
