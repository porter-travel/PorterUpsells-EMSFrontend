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
        Schema::create('fulfilment_keys', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('key');
            $table->foreignId('hotel_id')->constrained();
            $table->dateTime('expires_at')->nullable();
            $table->string('name');
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fulfilment_keys');
    }
};
