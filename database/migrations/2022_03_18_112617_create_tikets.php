<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTikets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('status',80)->nullable();
            $table->string('reason',255)->nullable();
            $table->longtext('details')->nullable();
            $table->timestamps();
        });

        Schema::create('tickets_replies', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_id')->unsigned()->nullable();
            $table->string('user_id',80)->nullable();
            $table->longtext('body')->nullable();
            $table->timestamps();
        });
        Schema::create('tickets_images', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_id')->unsigned()->nullable();
            $table->string('image',255)->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
