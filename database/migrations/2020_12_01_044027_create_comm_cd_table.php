<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommCdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comm_cd', function (Blueprint $table) {
            $table->string('comm1_cd', 10);
            $table->string('comm2_cd', 10);
            $table->string('comm2_nm', 40)->nullable();
            $table->string('reg_id', 15)->nullable();
            $table->string('reg_dtm', 14)->nullable();

            $table->index(['comm1_cd', 'comm2_cd']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comm_cd');
    }
}
