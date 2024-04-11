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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('hotel_id')->constrained();
            $table->longText('items');
            $table->string('name');
            $table->string('email');
            $table->string('booking_ref');
            $table->date('arrival_date');
            $table->string('stripe_id')->nullable();
            $table->string('payment_status');
            $table->float('subtotal');
            $table->float('total_tax');
            $table->float('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
