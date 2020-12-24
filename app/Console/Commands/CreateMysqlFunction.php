<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateMysqlFunction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:function {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create customized prepared procedure or functions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        if ($name == 'get_codelist') {
            DB::unprepared($this->get_codelist());
        }

        if ($name == 'get_codename') {
            DB::unprepared($this->get_codename());
        }

        if ($name == 'get_codebyname') {
            DB::unprepared($this->get_codebyname());
        }

        return 0;
    }

    private function get_codelist()
    {
        return "DROP PROCEDURE IF EXISTS get_codelist; CREATE PROCEDURE get_codelist(IN cd1 VARCHAR(20)) BEGIN SELECT comm2_cd, comm2_nm FROM  COMM_CD WHERE comm1_cd = cd1 AND comm2_cd NOT IN ('$$');  END";
    }

    private function get_codename()
    {
        return "DROP function IF EXISTS get_codename; CREATE function get_codename(cd1 VARCHAR(20), cd2 VARCHAR(20)) returns VARCHAR(100) BEGIN  DECLARE getname VARCHAR(100); SET getname = 'Code Err'; SELECT comm2_nm into getname FROM   COMM_CD  WHERE  comm1_cd = cd1  AND    comm2_cd = cd2; RETURN getname; END";
    }

    private function get_codebyname()
    {
        return "DROP function IF EXISTS get_codebyname; CREATE function get_codebyname(cd1 VARCHAR(20), cdnm VARCHAR(100)) returns VARCHAR(20) BEGIN DECLARE getcode VARCHAR(20); SET getcode = 'Code Err'; SELECT comm2_cd into getcode FROM   COMM_CD WHERE  comm1_cd = cd1 AND    comm2_nm = cdnm; RETURN getcode; END";
    }
}
