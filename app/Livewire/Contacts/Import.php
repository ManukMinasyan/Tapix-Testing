<?php

namespace App\Livewire\Contacts;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Import Contacts')]
class Import extends Component
{
    public function render()
    {
        return view('livewire.contacts.import');
    }
}
