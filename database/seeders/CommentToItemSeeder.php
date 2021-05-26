<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommentToItemSeeder extends Seeder
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
            
                DB::table('comments_to_items')->insert([
                'items' => $i,
                'subject' => Str::random(100),
                'description' => Str::random(400),            
                ]);
            }
        }
        
    }
}
