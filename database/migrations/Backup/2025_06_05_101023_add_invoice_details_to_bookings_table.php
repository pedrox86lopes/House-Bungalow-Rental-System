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
            // Add invoice related fields
            $table->string('invoice_number')->unique()->nullable()->after('status');
            $table->decimal('total_amount_before_taxes', 10, 2)->nullable()->after('total_price');
            $table->decimal('tax_rate', 5, 2)->default(23.00)->after('total_amount_before_taxes'); // Default IVA rate for Portugal
            $table->decimal('tax_amount', 10, 2)->nullable()->after('tax_rate');
            $table->timestamp('paid_at')->nullable()->after('status'); // To track when the booking was paid

            // Rename existing columns for clarity if needed, or adjust your logic
            // For example, if 'total_price' will now specifically mean the pre-tax total,
            // and you want a separate 'final_total_amount'
            // $table->renameColumn('total_price', 'sub_total_price'); // Example: if you want to rename
            // $table->decimal('final_total_amount', 10, 2)->nullable()->after('tax_amount');
            // For now, let's just make sure total_price holds the FINAL price if you intend to use it that way.
            // If 'total_price' is already the final price, you might not need another total_amount field.
            // Let's assume `total_price` IS the final price including taxes and we'll calculate subtotal from it.
            // Or better, let's use `total_amount` for the final price and derive `total_price` as subtotal.
            // For consistency with the invoice template, let's rename `total_price` to `total_amount`.

            $table->renameColumn('total_price', 'total_amount'); // Renaming total_price to total_amount
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_number',
                'total_amount_before_taxes',
                'tax_rate',
                'tax_amount',
                'paid_at',
            ]);
            $table->renameColumn('total_amount', 'total_price'); // Revert rename
        });
    }
};
