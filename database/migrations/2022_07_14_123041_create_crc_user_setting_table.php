<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crc_user_setting', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('newsletter')->default(0)->comment('0 - no, 1 - yesy');
            $table->integer('recommendation')->default(0)->comment('0 - no, 1 - yesy');
            $table->integer('special_offer_sale')->default(0)->comment('0 - no, 1 - yesy');
            $table->integer('marketing_from_fav_seller')->default(0)->comment('0 - no, 1 - yesy');
            $table->integer('buyers_feedback')->default(0)->comment('0 - no, 1 - yesy');
            $table->integer('sales_alert')->default(0)->comment('0 - no, 1 - yesy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crc_user_setting');
    }
};
