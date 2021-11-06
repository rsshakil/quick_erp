<?php

use Illuminate\Database\Seeder;
use App\Models\CMN\customer;
use App\Models\CMN\customer_address;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer_array=array(
            // [
                'merchant_id' => 1,
                'customer_name'=>'Mayeen Uddin',
                'contact_number'=>'01670514306',
            // ],
        );
        $customer_id=customer::insertGetId($customer_array);
        $customer_address_array=array(
            [
                'customer_id' => $customer_id,
                'district_id' => 1,
                'thana_id'=>1,
                'area_id'=>1,
                'address'=>'222/C Tejkunipara, Tejgaon, Dhaka'
            ],
            [
                'customer_id' => $customer_id,
                'district_id' => 2,
                'thana_id'=>1,
                'area_id'=>1,
                'address'=>'Difference address, different, Dhaka'
            ],
        );
        customer_address::insert($customer_address_array);
    }
}
