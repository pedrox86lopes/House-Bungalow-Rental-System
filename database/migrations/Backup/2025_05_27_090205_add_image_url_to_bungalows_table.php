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
        Schema::table('bungalows', function (Blueprint $table) {
            // Add the image_url column
            // We'll store the path to the image as a string.
            // It's nullable for now in case you have existing bungalows without images,
            // or if you want to allow bungalows without images.
            $table->string('image_url')->nullable()->after('description'); // You can place it after any existing column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bungalows', function (Blueprint $table) {
            // Drop the image_url column if the migration is rolled back
            $table->dropColumn('image_url');
        });
    }
};
