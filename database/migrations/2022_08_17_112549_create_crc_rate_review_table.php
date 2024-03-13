<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('crc_rate_review', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment('1 - Order Product, 2 - Seller');
            $table->integer('order_id')->default(0);
            $table->integer('product_id')->default(0);
            $table->integer('seller_id')->default(0);
            $table->integer('user_id');
            $table->integer('rating')->default(0);
            $table->longText('review')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_rate_review');
    }
};
