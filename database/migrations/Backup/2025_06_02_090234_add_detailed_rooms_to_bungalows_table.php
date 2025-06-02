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
            $table->integer('bedrooms')->after('image_url')->nullable();      // For 'Quartos' (number of bedrooms)
            $table->integer('beds')->after('bedrooms')->nullable();           // For 'Camas' (number of beds)
            $table->integer('bathrooms')->after('beds')->nullable();          // For 'Casas de Banho' (number of bathrooms)
            $table->integer('accommodates')->after('bathrooms')->nullable();  // For 'Acomoda' (number of guests it accommodates)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bungalows', function (Blueprint $table) {
            $table->dropColumn(['bedrooms', 'beds', 'bathrooms', 'accommodates']);
        });
    }
};
