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
        Schema::create('crc_gift_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_user_id');
            $table->string('from_name');
            $table->integer('recipient_user_id');
            $table->string('recipient_email');
            $table->string('gift_code');
            $table->float('gift_amount', 8, 2);
            $table->longText('message')->nullable();
            $table->integer('sender_card_id');
            $table->float('remaining_amount', 8, 2);
            $table->integer('is_gift_card_used')->default(0)->comment('0 - not used, 1 - used');
            $table->integer('order_id')->default(0);
            $table->longText('txn_raw')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_gift_cards');
    }
};
