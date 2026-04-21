<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_id')
                ->nullable()
                ->constrained('services')
                ->nullOnDelete();

            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 30);

            // Store as UTC in DB; convert to NZ time in UI.
            $table->dateTime('booking_start_at');

            $table->text('notes')->nullable();

            $table->enum('status', ['pending', 'paid', 'confirmed', 'cancelled'])
                ->default('pending');

            $table->decimal('booking_fee', 10, 2)->default(10.00);
            $table->char('currency', 3)->default('NZD');

            $table->string('payment_provider')->nullable();   // stripe
            $table->string('payment_reference')->nullable();  // checkout_session_id / payment_intent_id

            $table->timestamps();

            $table->index(['booking_start_at']);
            $table->index(['status']);
            $table->unique(['booking_start_at']); // prevents double-booking same start time (optional)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
