<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activity::insert([
            [
                'name' => 'calcio',
                'tipo' => 'mensile',
                'cost' => '100'
            ],
            [
                'name' => 'tennis',
                'tipo' => 'mensile',
                'cost' => '200'
            ],
            [
                'name' => 'nuoto',
                'tipo' => 'mensile',
                'cost' => '50'
            ],
        ]);
    }
}
