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
        Schema::create('order_details', function (Blueprint $table) {
            $table->integer('food_id')->index('fk_foods_has_orders_foods1_idx');
            $table->integer('orders_id')->index('fk_foods_has_orders_orders2_idx');
            $table->double('subtotal', null, 0)->nullable();
            $table->text('note')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('modifiers_id')->nullable()->index('fk_order_details_modifiers1_idx');

            $table->primary(['food_id', 'orders_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
