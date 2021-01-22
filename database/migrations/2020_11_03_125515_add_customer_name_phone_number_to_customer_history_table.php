<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerNamePhoneNumberToCustomerHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_histories', function (Blueprint $table) {
            $table->string('customer_name')->after('customer_id');
            $table->string('customer_phone_number')->after('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_histories', function (Blueprint $table) {
            $table->dropColumn('customer_name');
            $table->dropColumn('customer_phone_number');
        });
    }
}
