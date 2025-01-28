<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelAnalyticsTable extends Migration
{
    public function up()
    {
        Schema::create('hotel_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->date('view_date'); // New column for date-specific tracking
            $table->unsignedBigInteger('dashboard_views')->default(0);
            $table->unsignedBigInteger('cart_views')->default(0);
            $table->timestamps();

            $table->unique(['hotel_id', 'view_date']); // Ensure unique records per hotel per date
        });

        Schema::create('product_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->date('view_date'); // New column for date-specific tracking
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();

            $table->unique(['hotel_id', 'product_id', 'view_date']); // Ensure unique records per product per date
        });
    }

    public function down()
    {
        Schema::dropIfExists('hotel_analytics');
        Schema::dropIfExists('product_views');
    }
}
