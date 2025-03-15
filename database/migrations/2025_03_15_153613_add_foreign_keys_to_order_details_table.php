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
        Schema::table('order_details', function (Blueprint $table) {
            $table->foreign(['food_id'], 'fk_foods_has_orders_foods1')->references(['id'])->on('food')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['orders_id'], 'fk_foods_has_orders_orders2')->references(['id'])->on('orders')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['modifiers_id'], 'fk_order_details_modifiers1')->references(['id'])->on('modifiers')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign('fk_foods_has_orders_foods1');
            $table->dropForeign('fk_foods_has_orders_orders2');
            $table->dropForeign('fk_order_details_modifiers1');
        });
    }
};
