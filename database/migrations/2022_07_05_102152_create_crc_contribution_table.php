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
        Schema::create('crc_contribution', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('fundraising_title')->nullable();
            $table->string('fundraising_slogan')->nullable();
            $table->string('fundraising_banner')->nullable();
            $table->longText('about_fundraiser')->nullable();
            $table->float('target_amount', 8, 2)->default(0);
            $table->float('funded_amount', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_contribution');
    }
};
