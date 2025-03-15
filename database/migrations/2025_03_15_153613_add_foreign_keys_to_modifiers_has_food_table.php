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
        Schema::table('modifiers_has_food', function (Blueprint $table) {
            $table->foreign(['food_id'], 'fk_modifiers_has_food_food1')->references(['id'])->on('food')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['modifiers_id'], 'fk_modifiers_has_food_modifiers1')->references(['id'])->on('modifiers')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modifiers_has_food', function (Blueprint $table) {
            $table->dropForeign('fk_modifiers_has_food_food1');
            $table->dropForeign('fk_modifiers_has_food_modifiers1');
        });
    }
};
