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
        Schema::table('bookings', function (Blueprint $table) {
            // Based on previous errors, user_id and bungalow_id already exist.
            // So, only add start_date and end_date if they are genuinely missing.
            // You can add ->after('column_name') if you care about column order,
            // e.g., ->after('bungalow_id')
            $table->date('start_date');
            $table->date('end_date');

            // $table->timestamps(); // Uncomment if your bookings table doesn't have these either
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Only drop the columns that were added in this specific migration
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
};
