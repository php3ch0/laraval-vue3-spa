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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('role',20)->nullable();
            $table->string('firstname',100)->nullable();
            $table->string('lastname',100)->nullable();
            $table->string('telephone',20)->nullable();
            $table->string('address1')->nullable();
            $table->string('address2',100)->nullable();
            $table->string('town',100)->nullable();
            $table->string('postcode',10)->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->softDeletes();
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
