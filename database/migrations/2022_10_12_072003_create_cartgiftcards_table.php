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
        Schema::create('cartgiftcards', function (Blueprint $table) {
            $table->id();
            $table->string('from_name');
            $table->integer('recipient_user_id');
            $table->string('recipient_email');
            $table->float('gift_amount', 8, 2);
            $table->longText('message')->nullable();
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
        Schema::dropIfExists('cartgiftcards');
    }
};
