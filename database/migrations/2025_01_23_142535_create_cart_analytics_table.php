<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_analytics', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->date('view_date');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('variation_id')->constrained()->onDelete('cascade');
            $table->integer('added_to_cart_count');
        });

        Schema::create('email_analytics', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->integer('email_count');
            $table->date('sent_date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_analytics');
        Schema::dropIfExists('email_analytics');
    }
};
