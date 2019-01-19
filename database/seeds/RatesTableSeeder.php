<?php

use Illuminate\Database\Seeder;

use App\Garages\Rate;

class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rate::create([
            'title' => '1 Hour',
            'price' => 300,
            'duration_in_minutes' => 60,
        ]);

        Rate::create([
            'title' => '3 Hours',
            'price' => 450,
            'duration_in_minutes' => 180,
        ]);

        Rate::create([
            'title' => '6 Hours',
            'price' => 675,
            'duration_in_minutes' => 360,
        ]);

        Rate::create([
            'title' => 'All Day',
            'price' => 1012,
            'duration_in_minutes' => null,
        ]);
    }
}
