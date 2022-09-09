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
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('image')->nullable();
            $table->string('title')->nullable();
            $table->text('article')->nullable();
            $table->string('slug')->nullable();
            $table->string('order_by')->nullable();
            $table->timestamps();
        });

        Schema::create('projects_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('project_id')->nullable();
            $table->string('image')->nullable();
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
