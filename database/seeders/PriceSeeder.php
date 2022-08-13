<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prices')->insert([
            'hall_id' => 1,
            'status' => 'standart',
            'price' => 250
        ]);

        DB::table('prices')->insert([
            'hall_id' => 1,
            'status' => 'vip',
            'price' => 350
        ]);

        DB::table('prices')->insert([
            'hall_id' => 2,
            'status' => 'standart',
            'price' => 200
        ]);

        DB::table('prices')->insert([
            'hall_id' => 2,
            'status' => 'vip',
            'price' => 250
        ]);
    }
}
