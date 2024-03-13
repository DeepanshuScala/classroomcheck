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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->integer('store_user_id')->nullable();
            $table->text('store_url')->nullable();
            $table->text('store_name')->nullable();
            $table->text('email')->nullable();
            $table->text('resource_grade')->nullable();
            $table->text('resource_subject')->nullable();
            $table->text('product_price_type')->nullable();
            $table->text('product')->nullable();
            $table->integer('previous_listing')->default(0);
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
        Schema::dropIfExists('newsletters');
    }
};
