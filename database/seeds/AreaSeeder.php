<?php

use Illuminate\Database\Seeder;
use App\Models\COUNTRY\area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $area_array=array(
            ['district_id' => 1,'thana_id'=>1,'area_name'=>'Farmgate','area_distance'=>2],
            ['district_id' => 1,'thana_id'=>1,'area_name'=>'Karwan Bazar','area_distance'=>3],
            ['district_id' => 1,'thana_id'=>1,'area_name'=>'Bijoy Saroni','area_distance'=>4],

            ['district_id' => 1,'thana_id'=>2,'area_name'=>'Dhanmondi-3','area_distance'=>2],
            ['district_id' => 1,'thana_id'=>2,'area_name'=>'Dhanmondi-4','area_distance'=>3],
            ['district_id' => 1,'thana_id'=>2,'area_name'=>'Dhanmondi-5','area_distance'=>4],

            ['district_id' => 1,'thana_id'=>3,'area_name'=>'Asad gate','area_distance'=>2],
            ['district_id' => 1,'thana_id'=>3,'area_name'=>'Town Hall','area_distance'=>3],
            ['district_id' => 1,'thana_id'=>3,'area_name'=>'Shia Mosjid','area_distance'=>5],

            ['district_id' => 2,'thana_id'=>4,'area_name'=>'Uchitpur','area_distance'=>2],
            ['district_id' => 2,'thana_id'=>4,'area_name'=>'Kala Paharia','area_distance'=>3],
            ['district_id' => 2,'thana_id'=>4,'area_name'=>'Khagakanda','area_distance'=>5],

            ['district_id' => 3,'thana_id'=>5,'area_name'=>'Munshat','area_distance'=>2],
            ['district_id' => 3,'thana_id'=>5,'area_name'=>'Dercouta','area_distance'=>3],
            ['district_id' => 3,'thana_id'=>5,'area_name'=>'Kandirpar','area_distance'=>5],

            ['district_id' => 4,'thana_id'=>6,'area_name'=>'Chowmuhoni','area_distance'=>2],
            ['district_id' => 4,'thana_id'=>6,'area_name'=>'Chowrasta','area_distance'=>3],
            ['district_id' => 4,'thana_id'=>6,'area_name'=>'Maizdee','area_distance'=>5],

            ['district_id' => 4,'thana_id'=>7,'area_name'=>'Companygonje Bazar','area_distance'=>2],
            ['district_id' => 4,'thana_id'=>7,'area_name'=>'Kobirhat','area_distance'=>3],
            ['district_id' => 4,'thana_id'=>7,'area_name'=>'Golapganj','area_distance'=>5],

            ['district_id' => 4,'thana_id'=>8,'area_name'=>'Sonaimuri Bazar','area_distance'=>2],
            ['district_id' => 4,'thana_id'=>8,'area_name'=>'Chatarpaiya','area_distance'=>3],
            ['district_id' => 4,'thana_id'=>8,'area_name'=>'Kashipur','area_distance'=>5],
        );
        area::insert($area_array);
    }
}
