<?php

namespace Database\Seeders;

use App\Models\Associa;
use Illuminate\Database\Seeder;

class AssociaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Associa::insert([
            [
                'activity_id' => 1,
                'client_id' => 1
            ],
            [
                'activity_id' => 1,
                'client_id' => 2
            ],
            [
                'activity_id' => 2,
                'client_id' => 2
            ],
            [
                'activity_id' => 2,
                'client_id' => 3
            ],
            [
                'activity_id' => 3,
                'client_id' => 1
            ],
            [
                'activity_id' => 3,
                'client_id' => 3
            ],
        ]);
    }
}
