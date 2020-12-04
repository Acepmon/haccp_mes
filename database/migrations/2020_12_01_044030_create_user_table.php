<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->string('user_id', 15);
            $table->string('user_pw', 100)->nullable()->comment('SHA 256 Hash Algorithm');
            $table->string('user_nm', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('role_cd', 10)->nullable();
            $table->char('user_sts_yn', 1)->nullable()->comment('User Status (Y = active, N = inactive)');
            $table->string('reg_id', 15)->nullable();
            $table->string('reg_dtm', 14)->nullable();

            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
