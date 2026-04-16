<?php

declare(strict_types=1);

namespace App\Importers;

use App\Models\Company;
use App\Models\Tag;
use Tapix\Core\Data\MatchableField;
use Tapix\Core\Enums\MatchBehavior;
use Tapix\Core\Fields\FieldType;
use Tapix\Core\Fields\ImportField;
use Tapix\Core\Importing\BaseImporter;

final class CompanyImporter extends BaseImporter
{
    public function model(): string
    {
        return Company::class;
    }

    public function label(): string
    {
        return 'Companies';
    }

    public function fields(): array
    {
        return [
            ImportField::make('name')
                ->required()
                ->rules(['unique:companies,name'])
                ->guess(['company', 'company name', 'name', 'organization']),

            ImportField::make('industry')
                ->nullable()
                ->guess(['industry', 'sector', 'vertical', 'field']),

            ImportField::make('website')
                ->type(FieldType::Url)
                ->nullable()
                ->guess(['website', 'url', 'web', 'site', 'homepage']),

            ImportField::make('tags')
                ->type(FieldType::MultiChoice)
                ->acceptsArbitraryValues()
                ->relationship('tags', Tag::class, ['name'], MatchBehavior::MatchOrCreate)
                ->guess(['tags', 'labels', 'categories']),
        ];
    }

    /** @return array<int, MatchableField> */
    public function matchableFields(): array
    {
        return [
            MatchableField::name(),
        ];
    }

    public function hasExampleCsv(): bool
    {
        return false;
    }
}
