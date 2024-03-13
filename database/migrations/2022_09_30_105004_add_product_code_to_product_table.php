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
        Schema::table('crc_products', function (Blueprint $table) {
            //
            $table->string('product_code')->after('is_deleted'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crc_products', function (Blueprint $table) {
            //
            $table->dropColumn('product_code'); 
        });
    }
};
