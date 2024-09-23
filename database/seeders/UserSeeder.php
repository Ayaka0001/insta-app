<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;    
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;

        $users =[
            [
                'name' => 'Ashley Devito',
                'email' => 'ashley@mail.com',
                'password' => Hash::make('12345678'),
                'role_id' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],[
                'name' => 'Neena',
                'email' => 'neena@mail.com',
                'password' => Hash::make('11111111'),
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],[
                'name' => 'Roberto',
                'email' => 'roberta@mail.com',
                'password' => Hash::make('22222222'),
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $user->insert($users);
    }
}
