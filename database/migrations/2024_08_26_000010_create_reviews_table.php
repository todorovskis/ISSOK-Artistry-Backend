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
            $table->decimal('grade', 5, 2);
            $table->string('title');
            $table->string('review', 300);
            $table->timestamp('timeCreated');
            $table->foreignId('artistId')->constrained('artists')->onDelete('cascade');
            $table->foreignId('clientId')->constrained('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
