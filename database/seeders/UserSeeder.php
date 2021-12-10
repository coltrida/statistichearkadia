<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::insert([
            [
                'name' => 'cacao',
                'role' => '1',
                'email' => 'cacao@cacao.it',
                'password' => Hash::make('123456'),
            ],
            [
                'name' => 'cacao2',
                'role' => null,
                'email' => 'cacao2@cacao.it',
                'password' => Hash::make('123456'),
            ],

        ]);
    }
}
