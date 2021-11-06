<?php

use Illuminate\Database\Seeder;
use App\Models\APPLICATION\weight_list;

class WeightPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $weight_list_array=array(
            [
                'weight_name'=>'Below to 0 KG',
                // 'weight_rate'=>10
            ],
            [
                'weight_name'=>'1 to 2 KG',
                // 'weight_rate'=>15
            ],
            [
                'weight_name'=>'2 to 3 KG',
                // 'weight_rate'=>20
            ],
            [
                'weight_name'=>'3 to 5 KG',
                // 'weight_rate'=>25
            ],
            [
                'weight_name'=>'5 to 10 KG',
                // 'weight_rate'=>30
            ],
            [
                'weight_name'=>'10 to 20 KG',
                // 'weight_rate'=>40
            ],
        );
        weight_list::insert($weight_list_array);
    }
}
