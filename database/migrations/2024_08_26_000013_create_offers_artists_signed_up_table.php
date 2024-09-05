<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersArtistsSignedUpTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers_artists_signed_up', function (Blueprint $table) {
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');
            $table->primary(['offer_id', 'artist_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers_artists_signed_up');
    }
}
