<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++) {
            
            for($j = 1; $j <=4; $j++) {
            
                DB::table('comments')->insert([
                'users_id' => rand(1, 10),
                'subject' => Str::random(100),
                'description' => Str::random(400),
                'commentable_id' => 1,
                'commentable_type' => rand(0,1)? 'Item' : 'User',
                'created_at' => \Carbon\Carbon::now(),
                ]);
            }
        }
    }
}
