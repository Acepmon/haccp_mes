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
            factory(LoginHist::class, rand(10, 50))->create([
                'user_id' => $user->user_id,
            ]);
        });
    }
}
