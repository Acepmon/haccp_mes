<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:password {userId} {password=password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset user password';

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
        $userId = $this->argument('userId');
        $password = $this->argument('password');

        if (DB::table('USER')->where('USER_ID', $userId)->exists()) {
            DB::table('USER')->where('USER_ID', $userId)->update([
                'USER_PW' => Hash::make($password)
            ]);

            $this->info('Password has been reset!');
        } else {
            $this->error('User id not found in the database!');
        }

        return 0;
    }
}
