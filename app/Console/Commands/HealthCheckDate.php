<?php

namespace App\Console\Commands;

use App\CommCd;
use App\Notifications\RemindHealthCheck;
use App\User;
use App\Worker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class HealthCheckDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'health:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for any workers health check date is due.';

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
        $currDt = now()->addDays(15)->format('Ymd');
        $workers = Worker::where('HEALTH_CHK_DT', $currDt)->get();

        $ids = CommCd::where('COMM1_CD', 'AAA')->whereNotIn('COMM2_CD', ['$$'])->get()->pluck('COMM2_CD')->toArray();
        $admins = User::whereIn('USER_ID', $ids)->get();

        foreach ($admins as $admin) {
            foreach ($workers as $worker) {
                $admin->notify(new RemindHealthCheck($worker));
            }
        }

        return 0;
    }
}
