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
            $table->id();
            $table->string('order_id');
            $table->string('buyer_id');
            $table->string('buyer_name');
            $table->string('buyer_city');
            $table->string('buyer_state');
            $table->string('buyer_country');
            $table->string('buyer_address');
            $table->string('product_id');
            $table->string('product_quantity');
            $table->integer('billing_amount');
            $table->string('buyer_contact_no');
            $table->string('payment_method');
            $table->string('order_status');
            $table->timestamps();
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
