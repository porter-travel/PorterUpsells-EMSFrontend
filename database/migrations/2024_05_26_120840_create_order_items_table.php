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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('variation_id')->constrained();
            $table->string('product_name');
            $table->string('variation_name');
            $table->integer('quantity');
            $table->float('price');
            $table->string('image');
            $table->date('date');
            $table->string('product_type');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
