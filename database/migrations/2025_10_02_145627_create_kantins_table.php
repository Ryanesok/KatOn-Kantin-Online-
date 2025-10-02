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
        Schema::create('kantins', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama kantin (Kantin Fakultas A, dll)
            $table->string('fakultas'); // Nama fakultas
            $table->string('location')->nullable(); // Lokasi spesifik
            $table->text('description')->nullable(); // Deskripsi kantin
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kantins');
    }
};
