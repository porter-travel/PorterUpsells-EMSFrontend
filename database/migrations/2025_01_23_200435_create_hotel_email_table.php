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
        Schema::create('hotel_emails', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('key_message');
            $table->string('button_text');
            $table->json('featured_products')->nullable();
            $table->longText('additional_information');
            $table->string('email_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_emails');
    }
};
