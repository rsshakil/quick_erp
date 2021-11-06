<?php

use Illuminate\Database\Seeder;
use App\Models\APPLICATION\charge_package;

class ChargePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $charge_package_array=array(
            [
                'charge_list_id'=>1,
                'weight_list_id'=>1,
                'charge'=>10
            ],
            [
                'charge_list_id'=>1,
                'weight_list_id'=>2,
                'charge'=>15
            ],
            [
                'charge_list_id'=>1,
                'weight_list_id'=>3,
                'charge'=>20
            ],
            [
                'charge_list_id'=>1,
                'weight_list_id'=>4,
                'charge'=>25
            ],
            [
                'charge_list_id'=>1,
                'weight_list_id'=>5,
                'charge'=>30
            ],
            [
                'charge_list_id'=>1,
                'weight_list_id'=>6,
                'charge'=>40
            ],
            [
                'charge_list_id'=>2,
                'weight_list_id'=>1,
                'charge'=>12
            ],
            [
                'charge_list_id'=>2,
                'weight_list_id'=>2,
                'charge'=>17
            ],
            [
                'charge_list_id'=>2,
                'weight_list_id'=>3,
                'charge'=>22
            ],
            [
                'charge_list_id'=>2,
                'weight_list_id'=>4,
                'charge'=>27
            ],
            [
                'charge_list_id'=>2,
                'weight_list_id'=>5,
                'charge'=>32
            ],
            [
                'charge_list_id'=>2,
                'weight_list_id'=>6,
                'charge'=>42
            ],
        );
        charge_package::insert($charge_package_array);
    }
}
