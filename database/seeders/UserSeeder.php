<?php

namespace Database\Seeders;

use App\Models\User;
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
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '123@Mudar',
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => '123@Mudar',
            ],
            [
                'name' => 'John',
                'email' => 'john@gmail.com',
                'password' => '123@Mudar',
            ],
            [
                'name' => 'Doe',
                'email' => 'doe@gmail.com',
                'password' => '123@Mudar',
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
