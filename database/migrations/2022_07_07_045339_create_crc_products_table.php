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
        Schema::create('crc_products', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id')->nullable();
            $table->string('product_type')->nullable();
            $table->integer('language')->default(0);
            $table->integer('resource_type')->default(0);
            $table->string('product_title')->nullable();
            $table->string('product_file')->nullable();
            $table->string('main_image')->nullable();
            $table->text('description')->nullable();
            $table->string('year_level')->nullable();
            $table->integer('subject_area')->nullable();
            $table->string('custom_category')->nullable();
            $table->integer('outcome_country')->default(0);
            $table->string('standard_outcome')->nullable();
            $table->string('teaching_duration')->nullable();
            $table->string('no_of_pages_slides')->nullable();
            $table->string('answer_key')->nullable();
            $table->string('is_paid_or_free')->nullable()->comment('paid, free');
            $table->string('single_license')->nullable();
            $table->string('multiple_license')->nullable();
            $table->string('tax_code')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('terms_and_conditions')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crc_products');
    }
};
