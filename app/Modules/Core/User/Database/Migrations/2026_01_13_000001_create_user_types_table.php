<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Create user_types table
 *
 * GOVERNANCE: User types define identity classification.
 * Predefined records: reseller_owner, company_admin, company_user, driver
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Seed predefined user types
        $this->seedUserTypes();
    }

    public function down(): void
    {
        Schema::dropIfExists('user_types');
    }

    private function seedUserTypes(): void
    {
        $types = [
            ['name' => 'reseller_owner', 'description' => 'Reseller owner with top-level access intent'],
            ['name' => 'company_admin', 'description' => 'Company administrator with company-level access intent'],
            ['name' => 'company_user', 'description' => 'Standard company user'],
            ['name' => 'driver', 'description' => 'Driver user with limited access intent'],
        ];

        foreach ($types as $type) {
            DB::table('user_types')->insert(array_merge($type, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
};
