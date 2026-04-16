<?php

declare(strict_types=1);

namespace App\Importers;

use App\Enums\ContactStatus;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Tag;
use Tapix\Core\Data\MatchableField;
use Tapix\Core\Enums\MatchBehavior;
use Tapix\Core\Fields\FieldType;
use Tapix\Core\Fields\ImportField;
use Tapix\Core\Importing\BaseImporter;

final class ContactImporter extends BaseImporter
{
    public function model(): string
    {
        return Contact::class;
    }

    public function label(): string
    {
        return 'Contacts';
    }

    public function fields(): array
    {
        return [
            ImportField::make('first_name')
                ->required()
                ->guess(['first name', 'first', 'given name', 'fname']),

            ImportField::make('last_name')
                ->required()
                ->guess(['last name', 'last', 'surname', 'family name', 'lname']),

            ImportField::make('email')
                ->required()
                ->type(FieldType::Email)
                ->rules(['email', 'unique:contacts,email'])
                ->guess(['email', 'email address', 'e-mail', 'mail']),

            ImportField::make('phone')
                ->type(FieldType::Phone)
                ->nullable()
                ->guess(['phone', 'phone number', 'telephone', 'mobile', 'cell']),

            ImportField::make('job_title')
                ->nullable()
                ->guess(['job title', 'title', 'position', 'role']),

            ImportField::make('status')
                ->type(FieldType::Choice)
                ->options(array_map(
                    fn (ContactStatus $status) => ['label' => $status->name, 'value' => $status->value],
                    ContactStatus::cases(),
                ))
                ->guess(['status', 'state', 'contact status']),

            ImportField::make('company')
                ->type(FieldType::Text)
                ->relationship('company', Company::class, ['name'], MatchBehavior::MatchOrCreate)
                ->guess(['company', 'company name', 'organization', 'org']),

            ImportField::make('tags')
                ->type(FieldType::MultiChoice)
                ->acceptsArbitraryValues()
                ->relationship('tags', Tag::class, ['name'], MatchBehavior::MatchOrCreate)
                ->guess(['tags', 'labels', 'categories', 'keywords']),
        ];
    }

    /** @return array<int, MatchableField> */
    public function matchableFields(): array
    {
        return [
            MatchableField::email('email'),
        ];
    }

    public function hasExampleCsv(): bool
    {
        return false;
    }
}
