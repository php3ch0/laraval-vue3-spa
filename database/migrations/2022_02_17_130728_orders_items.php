<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrdersItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items', function($table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->string('file',255)->nullable();
            $table->string('image',255)->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('qty')->unsigned()->nullable();
            $table->string('orientation',255)->nullable();
            $table->string('print',255)->nullable();
            $table->integer('stock_id')->unsigned()->nullable();
            $table->integer('envelope_id')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->decimal('price_saved',10,2)->nullable();
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
        //
    }
}
