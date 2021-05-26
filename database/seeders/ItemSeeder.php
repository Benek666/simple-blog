<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++) {
            
            DB::table('comments_to_items')->insert([
            'items_id' => $i,
            'users_id' => random(1,10),
            'subject' => Str::random(100),
            'description' => Str::random(400),            
            ]);
        }
    }
}
