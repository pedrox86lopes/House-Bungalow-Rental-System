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
            // total_price should be decimal for currency, e.g., 8 digits total, 2 after decimal
            $table->decimal('total_price', 8, 2)->after('end_date');
            // status can be a string or an enum. Enum is often preferred for fixed statuses.
            // Example for enum:
            $table->enum('status', ['pending', 'paid', 'cancelled', 'failed'])->default('pending')->after('total_price');
            // Or if you prefer a simple string:
            // $table->string('status')->default('pending')->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('total_price');
            $table->dropColumn('status');
        });
    }
};
