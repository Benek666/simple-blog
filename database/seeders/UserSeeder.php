<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userNames = ['Marek', 'Chrystian', 'Bogusław', 'Zbigniew', 'Szymon', 'Sebastian', 'Tymoteusz', 'Wezuwiusz', 'Apollo', 'Sylwester'];
        
        for($i = 0; $i < 10; $i++) {
            
            DB::table('users')->insert([
            'name' => $userNames[$i],
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'created_at' => \Carbon\Carbon::now(),
            
        ]);
        }
        
        
    }
}
