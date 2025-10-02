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
        // Add kantin_id to users table (untuk petugas kantin)
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('kantin_id')->nullable()->constrained('kantins')->onDelete('set null');
        });

        // Add kantin_id to menus table
        Schema::table('menus', function (Blueprint $table) {
            $table->foreignId('kantin_id')->constrained('kantins')->onDelete('cascade');
        });

        // Add kantin_id to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('kantin_id')->constrained('kantins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kantin_id']);
            $table->dropColumn('kantin_id');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['kantin_id']);
            $table->dropColumn('kantin_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['kantin_id']);
            $table->dropColumn('kantin_id');
        });
    }
};
