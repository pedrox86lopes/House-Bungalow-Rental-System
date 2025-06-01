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
            // Add user_id if it's not already there. It's crucial for linking bookings to users.
            // Ensure you have a 'users' table already, or create it before this migration.
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to users table

            // Add bungalow_id to link to the bungalow being booked
            $table->foreignId('bungalow_id')->constrained()->onDelete('cascade'); // Links to bungalows table

            // Add start_date and end_date
            $table->date('start_date');
            $table->date('end_date');

            // You might also want timestamps if not already present in your initial bookings table creation
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropConstrainedForeignId('user_id');
            $table->dropConstrainedForeignId('bungalow_id');

            // Then drop the columns
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
};
