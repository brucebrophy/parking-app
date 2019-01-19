<?php

use Illuminate\Database\Seeder;

use App\Garages\Garage;

class GaragesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Garage::create([
            'total_spots' => 15,
        ]);
    }
}
