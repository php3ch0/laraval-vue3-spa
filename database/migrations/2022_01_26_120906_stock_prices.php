<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StockPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_margins', function($table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('stock_id')->unsigned()->nullable();
            $table->integer('qty')->unsigned()->nullable();
            $table->integer('margin')->unsigned()->nullable();
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
