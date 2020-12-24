<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGetCodebynameFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared($this->get_codebyname());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP function IF EXISTS get_codebyname;');
    }

    private function get_codebyname()
    {
        return "DROP function IF EXISTS get_codebyname; CREATE function get_codebyname(cd1 VARCHAR(20), cdnm VARCHAR(100)) returns VARCHAR(20) BEGIN DECLARE getcode VARCHAR(20); SET getcode = 'Code Err'; SELECT COMM2_CD into getcode FROM   COMM_CD WHERE  COMM1_CD = cd1 AND    COMM2_NM = cdnm; RETURN getcode; END";
    }
}
