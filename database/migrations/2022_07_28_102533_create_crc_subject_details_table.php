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
        Schema::create('crc_subject_details', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->integer('grade_id')->default(0);
            $table->string('name')->nullable();
            $table->integer('status')->default(1)->comment('0 - inactive, 1 - active');
            $table->integer('is_deleted')->default(0)->comment('0 - not deleted, 1 - deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_subject_details');
    }
};
