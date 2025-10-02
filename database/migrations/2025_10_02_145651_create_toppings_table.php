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
        Schema::create('toppings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kantin_id')->constrained('kantins')->onDelete('cascade');
            $table->string('name'); // Nama topping (Extra Keju, Telur Mata Sapi, dll)
            $table->decimal('price', 10, 2); // Harga topping
            $table->text('description')->nullable(); // Deskripsi topping
            $table->boolean('is_available')->default(true); // Status ketersediaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toppings');
    }
};
