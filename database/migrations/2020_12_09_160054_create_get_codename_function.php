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
        return "DROP function IF EXISTS get_codename; CREATE function get_codename(cd1 VARCHAR(20), cd2 VARCHAR(20)) returns VARCHAR(100) BEGIN  DECLARE getname VARCHAR(100); SET getname = 'Code Err'; SELECT comm2_nm into getname FROM   COMM_CD  WHERE  comm1_cd = cd1  AND    comm2_cd = cd2; RETURN getname; END";
    }
}
