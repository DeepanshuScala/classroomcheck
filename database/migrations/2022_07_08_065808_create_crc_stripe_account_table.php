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
        Schema::create('crc_stripe_account', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('account_id')->nullable();
            $table->longText('raw_data')->nullable();
            $table->integer('approved_status')->default(0);
            $table->string('login_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_stripe_account');
    }
};
