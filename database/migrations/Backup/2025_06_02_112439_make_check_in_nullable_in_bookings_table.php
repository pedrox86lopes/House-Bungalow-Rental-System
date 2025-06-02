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
            // Change the column to be nullable
            // Ensure the column type matches what you originally defined (e.g., dateTime or date)
            $table->dateTime('check_in')->nullable()->change();
            // Or if it was a date field:
            // $table->date('check_in')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Revert to NOT NULL. Be careful if there are existing NULLs.
            // This might fail if you have existing rows with NULL check_in values.
            $table->dateTime('check_in')->nullable(false)->change();
            // Or if it was a date field:
            // $table->date('check_in')->nullable(false)->change();
        });
    }
};
