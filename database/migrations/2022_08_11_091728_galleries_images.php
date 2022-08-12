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
        Schema::create('galleries_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('gallery_id')->unsigned()->nullable();
            $table->string('image')->nullable();
            $table->string('alt')->nullable();
            $table->string('link')->nullable();
            $table->string('order_by')->nullable();
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
};
