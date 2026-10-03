<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('modal', 15, 2)->default(0)->after('sasaran');
            $table->decimal('pendapatan', 15, 2)->default(0)->after('modal');
        });
    }
    public function down(): void {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['modal', 'pendapatan']);
        });
    }
};