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
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('page_background_color')->default('#ffffff');
            $table->string('main_box_color')->default('#F5D6E1');
            $table->string('main_box_text_color')->default('#000000');
            $table->string('button_color')->default('#D4F6D1');
            $table->string('accent_color')->default('#C7EDF2');
            $table->string('text_color')->default('#000000');
            $table->string('button_text_color')->default('#000000');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('page_background_color');
            $table->dropColumn('main_box_color');
            $table->dropColumn('main_box_text_color');
            $table->dropColumn('button_color');
            $table->dropColumn('accent_color');
            $table->dropColumn('text_color');
            $table->dropColumn('button_text_color');
        });
    }
};
