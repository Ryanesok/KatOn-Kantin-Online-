<?php
// Catatan: File ini untuk memodifikasi tabel users bawaan Laravel

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->unique()->nullable()->after('email');
            $table->enum('role', ['admin_kantin', 'pembeli'])->default('pembeli')->after('password');
            $table->foreignId('kantin_id')->nullable()->constrained('kantins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kantin_id']);
            $table->dropColumn(['nim', 'role', 'kantin_id']);
        });
    }
};