<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginHistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_hist', function (Blueprint $table) {
            $table->string('user_id', 15);
            $table->string('login_dtm', 14)->comment('Format: YYYYMMDDHHMISS');
            $table->string('logout_dtm', 14)->nullable()->comment('Format: YYYYMMDDHHMISS');
            $table->string('ip_addr', 20)->nullable();

            $table->index(['user_id', 'login_dtm']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_hist');
    }
}
