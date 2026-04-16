<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('tapix.table_prefix', 'tapix_');

        Schema::create("{$prefix}failed_import_rows", function (Blueprint $table) use ($prefix) {
            $table->ulid('id')->primary();
            $table->ulid('import_id');

            if (config('tapix.tenant.enabled')) {
                $column = config('tapix.tenant.column', 'tenant_id');
                $table->string($column)->nullable()->index();
            }

            $table->json('data');
            $table->text('validation_error')->nullable();
            $table->timestamps();

            $table->foreign('import_id')
                ->references('id')
                ->on("{$prefix}imports")
                ->cascadeOnDelete();
        });
    }
};
