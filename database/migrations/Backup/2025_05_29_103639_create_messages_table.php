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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // Sender of the message (foreign key to users table)
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            // Receiver of the message (foreign key to users table)
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->string('subject')->nullable(); // Subject of the message
            $table->text('body'); // Content of the message
            $table->timestamp('read_at')->nullable(); // When the message was read
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
