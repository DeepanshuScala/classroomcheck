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
        Schema::create('contributionstransactions', function (Blueprint $table) {
            $table->id();
            $table->integer('contribution_id')->nullable();
            $table->longText('txn_ref')->nullable();
            $table->longText('txn_raw')->nullable();
            $table->longText('amount')->nullable();
            $table->longText('status')->nullable();
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
        Schema::dropIfExists('contributionstransactions');
    }
};
