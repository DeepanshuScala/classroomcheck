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
        Schema::create('crc_product_feature_list', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('category')->nullable();
            $table->integer('product_id')->default(0);
            $table->string('date')->nullable();
            $table->float('amount', 8, 2)->default(0);
            $table->integer('card_id')->default(0);
            $table->integer('payment_status')->default(0)->comment('0 - Pending, 1 - Success, 2 - Failure');
            $table->longText('payment_raw')->nullable();
            $table->string('payment_date')->nullable();
            $table->integer('status')->default(0)->comment('0 - inactive, 1 - active, 2 - Expired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_product_feature_list');
    }
};
