<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create users table
 *
 * GOVERNANCE: Users store identity data ONLY.
 * - A User has ONE user_type
 * - A User belongs to ONE Company
 * - Authorization data is managed via related tables
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_type_id')->constrained('user_types')->onDelete('restrict');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('company_id');
            $table->index('user_type_id');
            $table->index('is_active');
            $table->index(['company_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
