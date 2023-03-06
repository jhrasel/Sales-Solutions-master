<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->string('order_no');
            $table->string('order_status')->default('pending')->comment('pending,confirmed,follow_up,shipped,delivery,returned,cancel');
            $table->float('advanced',8,2)->default(0);
            $table->string('customer_name');
            $table->string('phone');
            $table->string('address');
            $table->boolean('cod')->default(true);
            $table->boolean('invoice_print')->default(false);
            $table->boolean('courier_entry')->default(false);
            $table->string('consignment_id')->nullable();
            $table->string('tracking_code')->nullable();
            $table->date('return_order_date')->nullable();
            $table->integer('grand_total')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
