<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">{{ __('Import Contacts') }}</flux:heading>
            <flux:text class="mt-1">{{ __('Upload a CSV or Excel file to import contacts into your database.') }}</flux:text>
        </div>
        <flux:button href="{{ route('contacts.index') }}" variant="ghost" icon="arrow-left" wire:navigate>
            {{ __('Back to Contacts') }}
        </flux:button>
    </div>

    <livewire:tapix.wizard
        :importer-class="\App\Importers\ContactImporter::class"
        :return-url="route('contacts.index')"
        :sample-file="storage_path('app/sample-csv/contacts_clean.csv')"
    />
</div>
