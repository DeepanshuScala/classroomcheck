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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('sortname', 255)->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->string('slug', 255)->nullable(false);
            $table->integer('phonecode')->nullable(false);
            $table->tinyInteger('status')->nullable(false);
            $table->integer('priority')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('countries');
    }
};
