<?php

namespace App\Livewire\Contacts;

use App\Models\Contact;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Contacts')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.contacts.index', [
            'contacts' => Contact::query()
                ->with('company', 'tags')
                ->when($this->search, fn ($query) => $query
                    ->where('first_name', 'like', "%{$this->search}%")
                    ->orWhere('last_name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                )
                ->latest()
                ->paginate(15),
        ]);
    }
}
