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
        Schema::create('crc_suggest_resource', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->integer('grade_id')->default(0);
            $table->integer('subject_id')->default(0);
            $table->integer('resource_id')->default(0);
            $table->longText('description')->nullable();
            $table->longText('other_description')->nullable();
            $table->integer('is_sent_to_seller')->default(0)->comment('0 - not sent, 1 - sent');
            $table->string('seller_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_suggest_resource');
    }
};
