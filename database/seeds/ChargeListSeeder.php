<?php

use Illuminate\Database\Seeder;
use App\Models\APPLICATION\charge_list;

class ChargeListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $charge_list_array=array(
            [
                'district_id' => 1,
                // 'charge_name'=>'Dhaka',
                'charge_rate'=>60
            ],
            [
                'district_id' => 2,
                // 'charge_name'=>'Narayongonj',
                'charge_rate'=>120
            ],
        );
        charge_list::insert($charge_list_array);
    }
}
