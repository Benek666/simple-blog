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
        for($i = 1; $i <= 30; $i++) {
            
            DB::table('items')->insert([
            'users_id' => rand(1,10),
            'subject' => 'Przykładowy temat wpisu', # Str::random(100),
            'description' => 'Przykładowy opis przykładowego wpisu, Przykładowy opis przykładowego wpisu, Przykładowy opis przykładowego wpisu', # Str::random(400),
            'created_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
