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
            
            DB::table('items')->insert([
            'users_id' => rand(1,10),
            'subject' => Str::random(100),
            'description' => Str::random(400),
            'created_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
