<?php

declare(strict_types=1);

use Tapix\Core\Importing\Readers\CsvReader;
use Tapix\Core\Importing\Readers\XlsxReader;
use Tapix\Core\Jobs\ExecuteImportJob;
use Tapix\Core\Jobs\ResolveMatchesJob;
use Tapix\Core\Jobs\ValidateColumnJob;
use Tapix\Core\Models\FailedImportRow;
use Tapix\Core\Models\Import;
use Tapix\Core\Models\Scopes\TenantScope;
use Tapix\Core\Notifications\ImportCompletedNotification;

return [
    'max_file_size' => 50 * 1024 * 1024,
    'max_rows' => 100_000,
    'chunk_size' => 500,

    'store' => [
        'path' => storage_path('app/tapix'),
        'remote_disk' => env('TAPIX_STORE_DISK'),
    ],

    'queues' => [
        'validation' => env('TAPIX_QUEUE_VALIDATION', config('queue.default')),
        'execution' => env('TAPIX_QUEUE_EXECUTION', config('queue.default')),
    ],

    // Queue timeout in seconds. Your queue connection's `retry_after` must
    // exceed this value (recommend retry_after >= job_timeout + 30).
    'job_timeout' => 600,
    'job_tries' => 3,
    'job_backoff' => [10, 30],

    'table_prefix' => 'tapix_',

    'models' => [
        'import' => Import::class,
        'failed_row' => FailedImportRow::class,
    ],

    'jobs' => [
        'execute' => ExecuteImportJob::class,
        'validate' => ValidateColumnJob::class,
        'resolve_matches' => ResolveMatchesJob::class,
    ],

    'tenant' => [
        'enabled' => false,
        'column' => 'tenant_id',
        'model' => null,
        'scope' => TenantScope::class,
    ],

    'readers' => [
        'csv' => CsvReader::class,
        'txt' => CsvReader::class,
        'xlsx' => XlsxReader::class,
    ],

    'custom_fields_adapter' => null,

    'notifications' => [
        'enabled' => true,
        'class' => ImportCompletedNotification::class,
    ],

    'cleanup_after_days' => 30,

    'importer_directories' => [
        app_path('Importers'),
    ],
    'importer_namespace' => 'App\\Importers',

    'routes' => [
        'enabled' => true,
        'prefix' => 'imports',
        'domain' => null,
        'middleware' => ['web', 'auth'],
    ],
];
