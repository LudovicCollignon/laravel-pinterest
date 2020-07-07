<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => "admin",
                'email' => "admin" . '@gmail.com',
                'password' => Hash::make('password')
            ],
            [
                'name' => "Ludo",
                'email' => "ludo" . '@gmail.com',
                'password' => Hash::make('password')
            ],
            [
                'name' => "Rémi",
                'email' => "remi" . '@gmail.com',
                'password' => Hash::make('password')
            ]
        ];
        
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
