<?php

namespace App\Console\Commands;

use App\EdocFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class EdocFileSeeder extends Command
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
        EdocFile::truncate();

        Artisan::call('db:seed', ['--class' => 'EdocFileSeeder']);

        $this->info('The command was successful!');
    }
}
