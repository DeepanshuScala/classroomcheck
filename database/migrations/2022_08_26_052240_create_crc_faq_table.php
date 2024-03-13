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
        Schema::create('crc_faq', function (Blueprint $table) {
            $table->id();
            $table->longText('question')->nullable();
            $table->longText('answer')->nullable();
            $table->integer('status')->default(1)->comment('0 - Inactive, 1 - Active');
            $table->integer('is_deleted')->default(1)->comment('0 - Not Deleted, 1- Deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_faq');
    }
};
