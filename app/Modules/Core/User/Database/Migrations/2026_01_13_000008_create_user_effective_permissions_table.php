<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create user_effective_permissions cache table
 *
 * GOVERNANCE: This is a DERIVED and CACHED table.
 * - Recalculated automatically when roles/modules change
 * - Used at runtime for authorization lookups
 * - Authorization checks MUST read from this table
 * - DO NOT dynamically compute permissions per request
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_effective_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('permission_key');
            $table->enum('source', ['role', 'direct', 'inherited', 'system'])->default('role');
            $table->boolean('has_restriction')->default(false);
            $table->boolean('is_valid')->default(true);
            $table->timestamps();

            $table->index('user_id');
            $table->index('company_id');
            $table->index('permission_key');
            $table->index('is_valid');
            $table->index(['user_id', 'permission_key', 'is_valid']);
            $table->index(['user_id', 'company_id', 'is_valid']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_effective_permissions');
    }
};
