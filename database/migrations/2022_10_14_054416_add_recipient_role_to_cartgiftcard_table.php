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
        Schema::table('cartgiftcards', function (Blueprint $table) {
            //
            $table->string('recipient_role')->nullable()->after('from_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cartgiftcards', function (Blueprint $table) {
            //
            $table->dropColumn('recipient_role');
        });
    }
};
