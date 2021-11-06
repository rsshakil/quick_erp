<?php

use Illuminate\Database\Seeder;
use App\Models\COUNTRY\district;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $district_array=array(
            ['district_name' => 'Dhaka'],
            ['district_name' => 'Narayongoje'],
            ['district_name' => 'Cumilla'],
            ['district_name' => 'Noakhali'],
            ['district_name' => 'Feni'],
            ['district_name' => 'Luxmipur'],
            ['district_name' => 'Chittagong'],
        );
        district::insert($district_array);
    }
}
