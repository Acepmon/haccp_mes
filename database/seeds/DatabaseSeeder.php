<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if(!Storage::has('files')) {
            Storage::makeDirectory('files');
        }

        // Mandatory Seeds
        $this->call(CommCdSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EdocFileSeeder::class);

        // Test Data (will not run on production environment)
        if (env('APP_ENV') != 'production') {
            $this->call(TestUserSeeder::class);
            $this->call(TestLoginHistSeeder::class);
            $this->call(TestCompInfoSeeder::class);
            $this->call(TestWorkerSeeder::class);
            $this->call(TestHaccpMstFileSeeder::class);
            $this->call(TestDocMgmtSeeder::class);
            $this->call(TestSecuDocMgmtSeeder::class);
        }
    }
}
