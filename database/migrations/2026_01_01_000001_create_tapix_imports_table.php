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

        Schema::create("{$prefix}imports", function (Blueprint $table) {
            $table->ulid('id')->primary();

            if (config('tapix.tenant.enabled')) {
                $column = config('tapix.tenant.column', 'tenant_id');
                $table->string($column)->nullable()->index();
            }

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('importer');
            $table->string('file_name');
            $table->string('file_path')->nullable();
            $table->string('status')->default('uploading');
            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('created_rows')->default(0);
            $table->unsignedInteger('updated_rows')->default(0);
            $table->unsignedInteger('skipped_rows')->default(0);
            $table->unsignedInteger('failed_rows')->default(0);
            $table->json('headers')->nullable();
            $table->json('column_mappings')->nullable();
            $table->json('results')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }
};
