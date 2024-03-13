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
        Schema::create('crc_about_us', function (Blueprint $table) {
            $table->id();
            $table->longText('about_us')->nullable();
            $table->string('about_us_image')->nullable();
            $table->longText('our_vision')->nullable();
            $table->longText('our_mission')->nullable();
            $table->longText('founding_story_description')->nullable();
            $table->string('founding_story_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_about_us');
    }
};
