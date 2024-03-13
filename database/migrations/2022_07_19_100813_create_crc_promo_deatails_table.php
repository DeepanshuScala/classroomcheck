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
        Schema::create('crc_promo_deatails', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0)->comment('0 - public, 1 - private');
            $table->integer('promo_usage_for')->nullable()->comment('1 - store, 2 - users');
            $table->string('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('promo_code')->nullable();
            $table->string('start_at')->nullable();
            $table->string('end_at')->nullable();
            $table->float('amount', 8, 2)->default(0.00);
            $table->integer('status')->default(1)->comment('0 - deactive, 1 - active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_promo_deatails');
    }
};
