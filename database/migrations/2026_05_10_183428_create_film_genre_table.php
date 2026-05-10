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
        // Tabel pivot ini menghubungkan film dan genre (Many-to-Many) [cite: 7]
        Schema::create('film_genre', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke tabel films [cite: 147]
            $table->foreignId('film_id')->constrained()->onDelete('cascade');
            
            // Foreign Key ke tabel genres [cite: 147]
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_genre');
    }
};