<?php

use App\Models\Company;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('company has many contacts', function () {
    $company = Company::factory()->create();
    Contact::factory()->count(3)->for($company)->create();

    expect($company->contacts)->toHaveCount(3);
});

test('company has morph to many tags', function () {
    $company = Company::factory()->create();
    $tags = Tag::factory()->count(2)->create();

    $company->tags()->attach($tags);

    expect($company->tags)->toHaveCount(2);
});

test('company factory creates valid model', function () {
    $company = Company::factory()->create();

    expect($company->name)->toBeString()
        ->and($company->industry)->toBeString()
        ->and($company->website)->toBeString();
});
