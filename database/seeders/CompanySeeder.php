<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            ['name' => 'Acme Corp', 'industry' => 'Technology', 'website' => 'acmecorp.com'],
            ['name' => 'Globex Inc', 'industry' => 'Finance', 'website' => 'globex.com'],
            ['name' => 'Initech', 'industry' => 'Technology', 'website' => 'initech.com'],
            ['name' => 'Umbrella Ltd', 'industry' => 'Healthcare', 'website' => 'umbrella.com'],
            ['name' => 'Stark Industries', 'industry' => 'Manufacturing', 'website' => 'stark.com'],
            ['name' => 'Wayne Enterprises', 'industry' => 'Finance', 'website' => 'wayne.com'],
            ['name' => 'Hooli', 'industry' => 'Technology', 'website' => 'hooli.com'],
            ['name' => 'Pied Piper', 'industry' => 'Technology', 'website' => 'piedpiper.com'],
            ['name' => 'Soylent Corp', 'industry' => 'Retail', 'website' => 'soylent.com'],
            ['name' => 'Wonka Industries', 'industry' => 'Manufacturing', 'website' => 'wonka.com'],
        ];

        $tags = Tag::all();

        foreach ($companies as $data) {
            $company = Company::create($data);
            $company->tags()->attach($tags->random(rand(1, 3)));
        }
    }
}
