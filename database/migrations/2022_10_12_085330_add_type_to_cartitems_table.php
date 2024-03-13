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
        Schema::table('crc_cart_items', function (Blueprint $table) {
            //
            $table->string('type')->default('product')->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crc_cart_items', function (Blueprint $table) {
            //
            $table->dropColumn('type');
        });
    }
};
