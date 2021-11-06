<?php

use Illuminate\Database\Seeder;
use App\Models\COUNTRY\district;
use App\Models\COUNTRY\thana;

class ThanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thana_array=array(
            ['district_id' => 1,'thana_name'=>'Tejgaon','thana_distance'=>5],
            ['district_id' => 1,'thana_name'=>'Dhanmondi','thana_distance'=>10],
            ['district_id' => 1,'thana_name'=>'Mohammad pur','thana_distance'=>12],
            ['district_id' => 2,'thana_name'=>'Arai Hazar','thana_distance'=>15],
            ['district_id' => 3,'thana_name'=>'Chouddogram','thana_distance'=>12],
            ['district_id' => 4,'thana_name'=>'Begumgonj','thana_distance'=>10],
            ['district_id' => 4,'thana_name'=>'CompanyGonj','thana_distance'=>20],
            ['district_id' => 4,'thana_name'=>'Sonaimuri','thana_distance'=>25],
            ['district_id' => 5,'thana_name'=>'Dagon Bhuiyan','thana_distance'=>20],
            ['district_id' => 5,'thana_name'=>'Porsuram','thana_distance'=>30],
            ['district_id' => 6,'thana_name'=>'Bangla Bazar','thana_distance'=>10],
            ['district_id' => 7,'thana_name'=>'Satkania','thana_distance'=>10],
        );
        thana::insert($thana_array);
    }
}
