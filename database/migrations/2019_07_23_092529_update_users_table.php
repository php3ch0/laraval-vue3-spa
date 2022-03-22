<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //drop uneeded columns

        //add needed columns
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('role',20)->nullable();
            $table->string('title',20)->nullable();
            $table->string('firstname',100)->nullable();
            $table->string('lastname',100)->nullable();
            $table->string('company_name',100)->nullable();
            $table->string('company_logo',100)->nullable();
            $table->string('telephone',20)->nullable();
            $table->string('mobile',20)->nullable();
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
        Schema::table('users', function (Blueprint $table) {
        $table->string('name')->nullable();
        $table->dropColumn('role');
        $table->dropColumn('title');
        $table->dropColumn('firstname');
        $table->dropColumn('lastname');
        $table->dropColumn('company_name');
        $table->dropColumn('telephone');
        $table->dropColumn('mobile');
        $table->dropColumn('address1');
        $table->dropColumn('address2');
        $table->dropColumn('town');
        $table->dropColumn('postcode');
        });
    }
}
