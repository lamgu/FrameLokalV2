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
        Schema::create('films', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->foreignId('regency_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique(); // Untuk URL SEO friendly
            $table->string('poster');
            $table->text('synopsis');
            $table->year('year');
            $table->decimal('rating', 3, 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
