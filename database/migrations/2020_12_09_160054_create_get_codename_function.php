<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGetCodenameFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared($this->get_codename());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP function IF EXISTS get_codename;');
    }

    private function get_codename()
    {
        return "DROP function IF EXISTS get_codename; CREATE function get_codename(cd1 VARCHAR(20), cd2 VARCHAR(20)) returns VARCHAR(100) BEGIN  DECLARE getname VARCHAR(100); SET getname = 'Code Err'; SELECT COMM2_NM into getname FROM   COMM_CD  WHERE  COMM1_CD = cd1  AND    COMM2_CD = cd2; RETURN getname; END";
    }
}
