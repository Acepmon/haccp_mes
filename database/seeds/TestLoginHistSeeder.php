<?php

use App\LoginHist;
use App\User;
use Illuminate\Database\Seeder;

class TestLoginHistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::inRandomOrder()->each(function ($user) {
            factory(LoginHist::class)->create([
                'USER_ID' => $user->USER_ID,
            ]);
        });
    }
}
