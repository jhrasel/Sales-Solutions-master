<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMerchantCouriersChangeMerchantId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_couriers', function (Blueprint $table) {
            $table->string('shop_id')->after('id');
        });

        Schema::table('merchant_couriers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('merchant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
