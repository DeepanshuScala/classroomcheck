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
        Schema::create('featuretable', function (Blueprint $table) {
            $table->id();
            $table->string('basic_membership')->nullable();
            $table->string('premium_membership')->nullable();
            $table->string('all_seller_membership')->nullable();
            $table->string('basic_payout')->nullable();
            $table->string('premium_payout')->nullable();
            $table->string('allseller_payout')->nullable();
            $table->string('basic_transaction')->nullable();
            $table->string('premium_transaction')->nullable();
            $table->string('allseller_transaction')->nullable();
            $table->string('basic_max')->nullable();
            $table->string('premium_max')->nullable();
            $table->string('allseller_max')->nullable();
            $table->string('basic_file')->nullable();
            $table->string('premium_file')->nullable();
            $table->string('allseller_file')->nullable();
            $table->string('basic_video')->nullable();
            $table->string('premium_video')->nullable();
            $table->string('allseller_video')->nullable();
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
        Schema::dropIfExists('featuretable');
    }
};
