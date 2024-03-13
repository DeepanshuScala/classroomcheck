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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable()->comment('for child answer');
            $table->integer('sender_id')->nullable()->comment('who has send question, login user (seller or buyer');
            $table->integer('receiver_id')->nullable()->comment('who has receive question, user(seller or buyer)');
            $table->integer('product_id')->nullable();
            $table->longText('question')->nullable();
            $table->integer('type')->default(0)->comment("Type: for question and anwer 0 means Queston 1 meand Amswer");
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
        Schema::dropIfExists('questions');
    }
};
