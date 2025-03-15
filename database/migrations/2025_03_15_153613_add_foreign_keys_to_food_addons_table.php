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
        Schema::table('food_addons', function (Blueprint $table) {
            $table->foreign(['addons_id'], 'fk_foods_has_orders_has_addons_addons1')->references(['id'])->on('addons')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['order_details_food_id', 'order_details_orders_id'], 'fk_food_addons_order_details1')->references(['food_id', 'orders_id'])->on('order_details')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('food_addons', function (Blueprint $table) {
            $table->dropForeign('fk_foods_has_orders_has_addons_addons1');
            $table->dropForeign('fk_food_addons_order_details1');
        });
    }
};
