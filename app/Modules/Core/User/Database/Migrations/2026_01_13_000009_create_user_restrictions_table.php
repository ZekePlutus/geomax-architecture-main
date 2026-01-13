<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create user_restrictions table
 *
 * GOVERNANCE: Stores user-specific restrictions.
 * Restriction types: vehicle, geofence, time, sub_account
 * These are evaluated at runtime by the Execution Gate.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_restrictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('restriction_type', ['vehicle', 'geofence', 'time', 'sub_account']);
            $table->json('restriction_value');
            $table->timestamps();

            $table->index('user_id');
            $table->index('restriction_type');
            $table->index(['user_id', 'restriction_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_restrictions');
    }
};
