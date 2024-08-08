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
            $table->string('name')->nullable()->change();
            $table->date('arrival_date')->nullable()->change();
            $table->date('departure_date')->nullable()->change();
            $table->string('email_address')->nullable()->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->date('arrival_date')->nullable()->change();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->date('arrival_date')->nullable(false)->change();
            $table->date('departure_date')->nullable(false)->change();
            $table->string('email_address')->nullable(false)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->date('arrival_date')->nullable(false)->change();
        });
    }
};
