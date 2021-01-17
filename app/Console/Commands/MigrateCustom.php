<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateCustom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate_cust:refresh {tableName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate refresh specific table schema';

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
        $tableNm = $this->argument('tableName');

        Schema::dropIfExists(strtoupper($tableNm));

        $path = database_path("migrations/".$tableNm.".sql");
        $sql = file_get_contents($path);
        DB::unprepared($sql);

        return 0;
    }
}
