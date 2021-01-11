<?php

namespace App\Console\Commands;

use App\EdocFile;
use App\EdocFileHaccp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class EdocFileHaccpSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edoc_file:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reseed edoc file values';

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
        EdocFileHaccp::truncate();
        EdocFile::truncate();

        Artisan::call('db:seed', ['--class' => 'EdocFileHaccpSeeder']);

        $this->info('The command was successful!');
    }
}
