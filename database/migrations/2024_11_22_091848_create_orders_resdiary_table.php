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
        Schema::create('orders_resdiary', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('hotel_id')->constrained();
            $table->foreignId('order_id')->nullable()->constrained();
            $table->string('resdiary_id')->nullable();
            $table->string('resdiary_reference')->nullable();
            $table->string('customer_first_name')->default('awaiting');
            $table->string('customer_last_name')->default('confirmation');
            $table->string('customer_email')->default('hello@enhancemystay.com');
            $table->string('customer_mobile')->default('00');
            $table->date('visit_date');
            $table->time('visit_time');
            $table->integer('party_size');
            $table->string('special_requests')->nullable();
            $table->string('status')->default('unconfirmed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_resdiary');
    }
};
