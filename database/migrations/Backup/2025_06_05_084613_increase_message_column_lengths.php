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
        Schema::table('messages', function (Blueprint $table) {
            // Change 'subject' to TEXT and allow it to be nullable
            $table->text('subject')->nullable()->change();

            // Also change 'body' to TEXT and allow it to be nullable
            $table->text('body')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Revert to original string/varchar. This might still truncate data
            // if encrypted values (even if null) exist and are longer than 255.
            // For a safe rollback strategy with encrypted data, consider TEXT as permanent.
            // However, for development or if you're sure about data consistency:
            $table->string('subject', 255)->nullable()->change(); // Revert to nullable string
            $table->string('body', 255)->nullable()->change();   // Revert to nullable string
        });
    }
};
