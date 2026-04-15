<?php

use App\Enums\ContactStatus;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('contact belongs to a company', function () {
    $company = Company::factory()->create();
    $contact = Contact::factory()->for($company)->create();

    expect($contact->company->id)->toBe($company->id);
});

test('contact status is cast to enum', function () {
    $contact = Contact::factory()->create(['status' => 'active']);

    expect($contact->status)->toBe(ContactStatus::Active);
});

test('contact can exist without a company', function () {
    $contact = Contact::factory()->create(['company_id' => null]);

    expect($contact->company)->toBeNull();
});

test('contact factory creates valid model', function () {
    $contact = Contact::factory()->create();

    expect($contact->first_name)->toBeString()
        ->and($contact->last_name)->toBeString()
        ->and($contact->email)->toContain('@')
        ->and($contact->status)->toBeInstanceOf(ContactStatus::class);
});
