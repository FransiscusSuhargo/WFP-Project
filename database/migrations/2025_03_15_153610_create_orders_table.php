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
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->dateTime('date')->nullable();
            $table->integer('payments_id')->index('fk_orders_payments1_idx');
            $table->bigInteger('customers_id')->index('fk_orders_customers1_idx');
            $table->enum('type', ['Dine-in', 'Takeaway'])->nullable();
            $table->enum('status', ['process', 'ready', 'finished'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
