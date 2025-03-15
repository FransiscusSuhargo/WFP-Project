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
        Schema::create('modifiers_has_food', function (Blueprint $table) {
            $table->integer('modifiers_id')->index('fk_modifiers_has_food_modifiers1_idx');
            $table->integer('food_id')->index('fk_modifiers_has_food_food1_idx');

            $table->primary(['modifiers_id', 'food_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modifiers_has_food');
    }
};
