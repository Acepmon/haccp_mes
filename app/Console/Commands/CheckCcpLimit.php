<?php

namespace App\Console\Commands;

use App\CcpData;
use App\CcpEscData;
use App\CcpLimit;
use App\Jobs\CheckCcpLimit as JobsCheckCcpLimit;
use Illuminate\Console\Command;

class CheckCcpLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ccp:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for CCP data for any limit exceed';

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
        JobsCheckCcpLimit::dispatch();
    }
}
