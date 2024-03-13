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
        Schema::create('crc_report_issues', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->default(0);
            $table->integer('product_id')->default(0);
            $table->integer('user_id');
            $table->Text('subject')->nullable();
            $table->longText('issue')->nullable();
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
        Schema::dropIfExists('crc_report_issues');
    }
};
