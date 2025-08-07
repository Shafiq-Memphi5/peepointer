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
        //
        Schema::table('toilets', function (Blueprint $table) {
            $table->json('images'); // Not nullable for toilets
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->json('images')->nullable(); // Nullable for reviews
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('toilets', function (Blueprint $table) {
            $table->dropColumn('images');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
