<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class DropTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drop:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drops table';

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
        Schema::dropIfExists('USER');
        Schema::dropIfExists('COMM_CD');
        Schema::dropIfExists('LOGIN_HIST');
        Schema::dropIfExists('COMP_INFO');
        Schema::dropIfExists('WORKER');
        Schema::dropIfExists('HACCP_MST_FILE');
        Schema::dropIfExists('ATT_FILE');
        Schema::dropIfExists('DOC_MGMT');
        Schema::dropIfExists('EDOC_FILE');
        Schema::dropIfExists('SECU_DOC_MGMT');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('ITEM_MST');
        Schema::dropIfExists('BOM_CONFIG');
        Schema::dropIfExists('MYHH');
        Schema::dropIfExists('PROC_SRC');
        Schema::dropIfExists('PROC_DTL');
        Schema::dropIfExists('PROC_DTL_SUB');
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('migrations');
    }
}
