<?php

namespace App\Console\Commands;

use App\CommCd;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CommonCodeSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comm_cd:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reseed common code values';

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
        CommCd::truncate();

        Artisan::call('db:seed', ['--class' => 'CommCdSeeder']);

        $this->info('The command was successful!');
    }
}
