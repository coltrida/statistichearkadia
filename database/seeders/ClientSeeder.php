<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::insert([
                [
                    'name' => 'pippo'
                ],
                [
                    'name' => 'pluto'
                ],
                [
                    'name' => 'topolino'
                ],
        ]);
    }
}
