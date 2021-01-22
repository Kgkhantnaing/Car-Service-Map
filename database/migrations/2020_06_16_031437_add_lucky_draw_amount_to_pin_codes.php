<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLuckyDrawAmountToPinCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pin_codes', function (Blueprint $table) {
            $table->string('lucky_draw_amount')->after('is_used');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pin_codes', function (Blueprint $table) {
            $table->dropColumn('lucky_draw_amount');
        });
    }
}
