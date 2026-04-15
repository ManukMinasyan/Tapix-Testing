<?php

namespace App\Console\Commands;

use App\Enums\ContactStatus;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:generate-large-csv {rows=500 : Number of rows to generate}')]
#[Description('Generate a large sample CSV file for Tapix import testing')]
class GenerateLargeCsv extends Command
{
    public function handle(): void
    {
        $rows = (int) $this->argument('rows');
        $path = storage_path('app/sample-csv/contacts_large.csv');

        $companies = [
            'Acme Corp', 'Globex Inc', 'Initech', 'Umbrella Ltd', 'Stark Industries',
            'Wayne Enterprises', 'Hooli', 'Pied Piper', 'Soylent Corp', 'Wonka Industries',
            'NovaTech Solutions', 'FutureTech Labs', 'Zenith Global', 'Apex Dynamics', 'Vertex Systems',
        ];

        $tags = ['SaaS', 'Enterprise', 'Startup', 'B2B', 'B2C', 'E-commerce', 'Fintech', 'Healthcare'];
        $statuses = array_column(ContactStatus::cases(), 'value');

        $file = fopen($path, 'w');
        fputcsv($file, ['first_name', 'last_name', 'email', 'phone', 'job_title', 'status', 'company', 'tags']);

        for ($i = 1; $i <= $rows; $i++) {
            $selectedTags = array_slice($tags, 0, rand(1, 3));

            fputcsv($file, [
                fake()->firstName(),
                fake()->lastName(),
                "contact{$i}@example.com",
                fake()->phoneNumber(),
                fake()->jobTitle(),
                $statuses[array_rand($statuses)],
                $companies[array_rand($companies)],
                implode(', ', $selectedTags),
            ]);
        }

        fclose($file);

        $this->info("Generated {$rows} rows at {$path}");
    }
}
