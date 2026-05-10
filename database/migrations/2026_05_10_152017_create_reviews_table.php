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
        Schema::create('reviews', function (Blueprint $table) {
    $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang mengulas 
            $table->foreignId('film_id')->constrained()->onDelete('cascade'); // Film apa yang diulas 
            $table->integer('rating'); // Skala 1-5 
            $table->text('comment'); // Isi komentar 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
