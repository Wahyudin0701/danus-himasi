<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('character_settings', function (Blueprint $table) {
            $table->id();
            $table->string('filename');          // e.g. "Big-Head Blue Jacket Caricature.png"
            $table->string('display_name');      // e.g. "Jaket Biru"
            $table->boolean('show_on_home')->default(true);
            $table->boolean('show_on_login')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('character_settings');
    }
};
