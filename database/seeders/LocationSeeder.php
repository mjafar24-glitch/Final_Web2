<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['floor' => '1', 'aisle' => 'A', 'shelf_number' => '01'],
            ['floor' => '1', 'aisle' => 'A', 'shelf_number' => '02'],
            ['floor' => '1', 'aisle' => 'B', 'shelf_number' => '01'],
            ['floor' => '1', 'aisle' => 'B', 'shelf_number' => '02'],
            ['floor' => '2', 'aisle' => 'C', 'shelf_number' => '01'],
            ['floor' => '2', 'aisle' => 'C', 'shelf_number' => '02'],
            ['floor' => '2', 'aisle' => 'D', 'shelf_number' => '01'],
            ['floor' => '2', 'aisle' => 'D', 'shelf_number' => '02'],
        ];

        foreach ($locations as $loc) {
            Location::firstOrCreate($loc);
        }
    }
}
