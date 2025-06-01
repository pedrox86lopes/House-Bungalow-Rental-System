<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Change the column to a sufficient length, e.g., 20 characters
            // The 'change()' method requires 'doctrine/dbal' package.
            $table->string('status', 20)->change();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Revert to original length if needed, or a smaller default
            $table->string('status', 10)->change(); // Example, use your original if known
        });
    }
};
