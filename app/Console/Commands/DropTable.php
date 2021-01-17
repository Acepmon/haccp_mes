<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drop:table {-T|--table=all}';

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
        $arg = $this->option('table');
        $builder = DB::table('information_schema.TABLES')->where('TABLE_SCHEMA', config('database.connections.mysql.database'))->select('TABLE_NAME');

        if ($arg == 'all') {
            foreach ($builder->get() as $table) {
                Schema::dropIfExists(strtoupper($table->TABLE_NAME));
            }

            $this->info('All tables dropped.');
        } else {
            if ($builder->where('TABLE_NAME', strtoupper($arg))->exists()) {
                Schema::dropIfExists(strtoupper($arg));
                DB::table('migrations')->where('migration', 'LIKE', '%create_' . strtolower($arg) . '_table')->delete();
                $this->info('Table dropped.');
            } else {
                $this->error('Table does not exists.');
            }
        }
    }
}
