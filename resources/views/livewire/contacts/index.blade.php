<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">{{ __('Contacts') }}</flux:heading>
        <div class="flex items-center gap-3">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search contacts..." icon="magnifying-glass" size="sm" />
            <flux:button href="{{ route('contacts.import') }}" variant="primary" icon="arrow-up-tray" wire:navigate>
                {{ __('Import CSV') }}
            </flux:button>
        </div>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>{{ __('Name') }}</flux:table.column>
            <flux:table.column>{{ __('Email') }}</flux:table.column>
            <flux:table.column>{{ __('Company') }}</flux:table.column>
            <flux:table.column>{{ __('Job Title') }}</flux:table.column>
            <flux:table.column>{{ __('Status') }}</flux:table.column>
            <flux:table.column>{{ __('Tags') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($contacts as $contact)
                <flux:table.row>
                    <flux:table.cell class="font-medium">
                        {{ $contact->first_name }} {{ $contact->last_name }}
                    </flux:table.cell>
                    <flux:table.cell>{{ $contact->email }}</flux:table.cell>
                    <flux:table.cell>{{ $contact->company?->name ?? '—' }}</flux:table.cell>
                    <flux:table.cell>{{ $contact->job_title ?? '—' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm" :variant="match($contact->status->value) { 'active' => 'primary', 'inactive' => 'danger', 'lead' => 'warning' }">
                            {{ $contact->status->name }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex flex-wrap gap-1">
                            @foreach ($contact->tags as $tag)
                                <flux:badge size="sm" variant="outline">{{ $tag->name }}</flux:badge>
                            @endforeach
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="6" class="text-center">
                        {{ __('No contacts found.') }}
                        <flux:link href="{{ route('contacts.import') }}" wire:navigate>
                            {{ __('Import your first CSV') }}
                        </flux:link>
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

    <div>
        {{ $contacts->links() }}
    </div>
</div>
