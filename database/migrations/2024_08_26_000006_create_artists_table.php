<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
//            $table->string('username')->unique(); // Changed from 'name' to 'username'
//            $table->string('password');
//            $table->string('name');
//            $table->integer('age')->nullable();
//            $table->string('profilePicture')->nullable(); // Allow null if not required
//            $table->string('role'); // Include role field
//            $table->foreignId('countryId')->nullable()->constrained('countries')->onDelete('set null');
            $table->text('summary');
            $table->decimal('hourlyRate')->nullable();
            $table->string('jobTitle')->nullable();
            $table->string('portfolio')->default('');
            $table->foreignId('userId')->constrained('users')->onDelete('cascade'); // Foreign key reference to users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
