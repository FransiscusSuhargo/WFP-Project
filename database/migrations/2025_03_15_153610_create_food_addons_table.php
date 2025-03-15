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
        Schema::create('food_addons', function (Blueprint $table) {
            $table->integer('addons_id')->index('fk_foods_has_orders_has_addons_addons1_idx');
            $table->integer('count')->nullable();
            $table->integer('order_details_food_id');
            $table->integer('order_details_orders_id');

            $table->index(['order_details_food_id', 'order_details_orders_id'], 'fk_food_addons_order_details1_idx');
            $table->primary(['addons_id', 'order_details_food_id', 'order_details_orders_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_addons');
    }
};
