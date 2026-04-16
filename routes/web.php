<?php

use App\Livewire\Contacts\Import;
use App\Livewire\Contacts\Index;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('contacts', Index::class)->name('contacts.index');
    Route::livewire('contacts/import', Import::class)->name('contacts.import');
});

require __DIR__.'/settings.php';
