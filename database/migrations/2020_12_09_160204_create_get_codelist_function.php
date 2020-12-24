<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGetCodelistFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared($this->get_codelist());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS get_codelist;');
    }

    private function get_codelist()
    {
        return "DROP PROCEDURE IF EXISTS get_codelist; CREATE PROCEDURE get_codelist(IN cd1 VARCHAR(20)) BEGIN SELECT COMM2_CD, COMM2_NM FROM  COMM_CD WHERE COMM1_CD = cd1 AND COMM2_CD NOT IN ('$$');  END";
    }
}
