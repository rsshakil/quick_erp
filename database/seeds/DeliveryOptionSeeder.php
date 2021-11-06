<?php

use Illuminate\Database\Seeder;
use App\Models\APPLICATION\delivery_option;

class DeliveryOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $delivery_option_array=array(
            ['option_name' => 'COD','option_rate'=>10],
            ['option_name' => 'BKash','option_rate'=>2],
            ['option_name' => 'Bank','option_rate'=>1],
            ['option_name' => 'Card','option_rate'=>2],
            ['option_name' => 'Nagad','option_rate'=>2],
            ['option_name' => 'Ucash','option_rate'=>3],
        );
        delivery_option::insert($delivery_option_array);
    }
}
