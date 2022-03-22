<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function($table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('status')->nullable();
            $table->string('ref')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->integer('delivery_id')->nullable();
            $table->decimal('delivery_cost',10,2)->nullable();
            $table->decimal('total_net',10,2)->nullable();
            $table->decimal('total_vat',10,2)->nullable();
            $table->decimal('total',10,2)->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('town')->nullable();
            $table->string('county')->nullable();
            $table->string('postcode')->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->text('problem_text')->nullable();
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
