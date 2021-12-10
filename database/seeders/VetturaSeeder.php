<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class VetturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Car::insert([
            [
                'name' => 'panda'
            ],
            [
                'name' => 'ferrai'
            ],
            [
                'name' => 'punto'
            ]
        ]);
    }
}
