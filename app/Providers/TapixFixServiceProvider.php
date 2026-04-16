<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;
use Tapix\Core\Data\ColumnData;
use Tapix\Core\Enums\DateFormat;
use Tapix\Core\Enums\NumberFormat;

/**
 * Temporary fixes for Tapix alpha version mismatches.
 *
 * The tapix/livewire package references methods (ColumnData::from,
 * GenerateExampleCsv) that don't exist yet in tapix/core.
 * This provider patches the Livewire synthesizer until stable release.
 */
class TapixFixServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::propertySynthesizer(FixedColumnDataSynth::class);
    }
}

class FixedColumnDataSynth extends Synth
{
    public static $key = 'tapix_cd';

    public static function match($target): bool
    {
        return $target instanceof ColumnData;
    }

    public static function matchByType($type): bool
    {
        return $type === ColumnData::class;
    }

    public function dehydrate($target): array
    {
        return [$target->toArray(), []];
    }

    public function hydrate($value, $meta): ColumnData
    {
        return new ColumnData(
            source: $value['source'],
            target: $value['target'],
            entityLink: $value['entityLink'] ?? null,
            dateFormat: isset($value['dateFormat']) ? DateFormat::from($value['dateFormat']) : null,
            numberFormat: isset($value['numberFormat']) ? NumberFormat::from($value['numberFormat']) : null,
        );
    }
}
