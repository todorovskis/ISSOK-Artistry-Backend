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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 1000);
            $table->string('status');
            $table->string('generatedImage')->nullable();
            $table->enum('mode', ['REGULAR', 'TOURNAMENT']);
            $table->timestamp('timeCreated');
            $table->decimal('timeWorkedOn', 8, 2)->nullable();
            $table->text('content')->nullable();
            $table->decimal('price', 8, 2);
            $table->foreignId('artist_id')->nullable()->constrained('artists')->onDelete('set null');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
