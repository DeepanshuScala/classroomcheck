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
        Schema::create('seller__social__media', function (Blueprint $table) {
            $table->id();
            $table->string('storeurl')->nullable();
            $table->string('store_name')->nullable();
            $table->string('email')->nullable();
            $table->string('user_id')->nullable();
            $table->string('store_fb_url')->nullable();
            $table->string('store_insta_url')->nullable();
            $table->string('submission_type')->nullable();
            $table->string('submission_type_details')->nullable();
            $table->string('resource_grade')->nullable();
            $table->string('resource_subject')->nullable();
            $table->string('explain_submission')->nullable();
            $table->string('media')->nullable();
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
        Schema::dropIfExists('seller__social__media');
    }
};
