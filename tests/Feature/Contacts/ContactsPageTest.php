<?php

use App\Enums\ContactStatus;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('contacts page requires authentication', function () {
    $this->get(route('contacts.index'))
        ->assertRedirect(route('login'));
});

test('contacts page renders for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('contacts.index'))
        ->assertSuccessful();
});

test('contacts page displays seeded contacts', function () {
    $user = User::factory()->create();
    $company = Company::factory()->create(['name' => 'Acme Corp']);
    $contact = Contact::factory()->for($company)->create([
        'first_name' => 'John',
        'last_name' => 'Smith',
        'email' => 'john@example.com',
        'status' => ContactStatus::Active,
    ]);

    $this->actingAs($user)
        ->get(route('contacts.index'))
        ->assertSuccessful()
        ->assertSee('John')
        ->assertSee('Smith')
        ->assertSee('john@example.com')
        ->assertSee('Acme Corp');
});

test('contacts page displays tags', function () {
    $user = User::factory()->create();
    $contact = Contact::factory()->create();
    $tag = Tag::factory()->create(['name' => 'SaaS']);
    $contact->tags()->attach($tag);

    $this->actingAs($user)
        ->get(route('contacts.index'))
        ->assertSuccessful()
        ->assertSee('SaaS');
});

test('import page requires authentication', function () {
    $this->get(route('contacts.import'))
        ->assertRedirect(route('login'));
});

test('import page renders for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('contacts.import'))
        ->assertSuccessful()
        ->assertSee('Import Contacts');
});
