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
        Schema::create('food', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 45)->nullable();
            $table->string('description', 45)->nullable();
            $table->text('nutrition_value')->nullable();
            $table->double('price', null, 0)->nullable();
            $table->integer('categories_id')->index('fk_foods_categories1_idx');
            $table->string('foodscol', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
