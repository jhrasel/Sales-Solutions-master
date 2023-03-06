<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<<< HEAD:database/migrations/2023_03_05_153328_create_order_notes_table.php
class CreateOrderNotesTable extends Migration
========
class CreateOrderConfigsTable extends Migration
>>>>>>>> 17fc7f8db1fe8fe36a9f488322246e5b76e8f1ce:database/migrations/2023_03_06_100540_create_order_configs_table.php
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<<< HEAD:database/migrations/2023_03_05_153328_create_order_notes_table.php
        Schema::create('order_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('type');
            $table->string('note');
========
        Schema::create('order_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('invoice_print')->default(false);
            $table->boolean('courier_entry')->default(false);
>>>>>>>> 17fc7f8db1fe8fe36a9f488322246e5b76e8f1ce:database/migrations/2023_03_06_100540_create_order_configs_table.php
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
<<<<<<<< HEAD:database/migrations/2023_03_05_153328_create_order_notes_table.php
        Schema::dropIfExists('order_notes');
========
        Schema::dropIfExists('order_configs');
>>>>>>>> 17fc7f8db1fe8fe36a9f488322246e5b76e8f1ce:database/migrations/2023_03_06_100540_create_order_configs_table.php
    }
}
