<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing unique constraint on nim
            $table->dropUnique(['nim']);
            
            // Add a composite unique constraint so a user can be in multiple periods,
            // but only once per period.
            $table->unique(['nim', 'periode_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nim', 'periode_id']);
            $table->unique('nim');
        });
    }
};
