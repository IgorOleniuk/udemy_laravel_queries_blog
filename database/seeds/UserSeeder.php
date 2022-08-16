<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\User', 10)->create()->each(function ($user) {
            $user->posts()->saveMany(factory('App\Models\Post', mt_rand(1, 6))->make());
        });
    }
}
