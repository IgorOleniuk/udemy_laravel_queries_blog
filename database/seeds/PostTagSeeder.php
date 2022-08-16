<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0;$i < 20; $i++) {
            DB::table('post_tag')->insert([
                'post_id' => mt_rand(1, \App\Models\Post::all()->count()),
                'tag_id' => mt_rand(1, 5)
            ]);
        }
    }
}
