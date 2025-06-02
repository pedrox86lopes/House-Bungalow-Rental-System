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
            $table->string('guest_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // If you ever want to revert, ensure you handle existing null values if needed.
            // This will make it NOT NULL again, which might fail if there are existing NULLs.
            // A better 'down' would be to convert nulls to an empty string or specific default first.
            $table->string('guest_name')->nullable(false)->change();
        });
    }
};
