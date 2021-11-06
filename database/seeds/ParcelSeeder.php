<?php

use App\Models\ACCOUNTS\parcel_account;
use Illuminate\Database\Seeder;
use App\Models\PARCEL\parcel;
use App\Models\CMN\customer;
use App\Models\MERCHANT\merchant;

class ParcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //customer 1 weight 1
        $customer_parcel_info=customer::select('customers.merchant_id','ca.district_id',
        'customers.customer_name','charge_rate',
        'charge as weight_charge')
        ->join('customer_addresses as ca','ca.customer_id','=','customers.id')
        ->join('charge_lists as cl','cl.district_id','=','ca.district_id')
        ->join('charge_packages as cp','cp.charge_list_id','=','cl.id')
        ->where('cp.weight_list_id',2)
        ->where('customers.id',1)
        ->where('ca.id',1)
        ->where('cl.id',1)
        ->first();
        $merchant_info=merchant::find(1);
        $cod=10;
        $collection_amount=100;

        $charge_rate=$customer_parcel_info->charge_rate;
        $weight_charge=$customer_parcel_info->weight_charge;

        $charge_amount=$charge_rate+$weight_charge+(($collection_amount*$cod)/100);
        $total_collection= $charge_amount+$collection_amount;
        $parcel_array=array(
                'customer_address_id' => 1,
                'merchant_id'=>1,
                'charge_package_id'=>2,
                'delivery_option_id'=>1,
                'marchent_order_id'=>'A1B56C68',
                'pickup_address'=>$merchant_info->business_address,
                'product_description'=>'Book',
                'remark'=>'Good Condition'
        );
        $parcel_id=parcel::insertGetId($parcel_array);
        $parcel_account_array=array(
            'parcel_id'=>$parcel_id,
            'collection_amount'=>$collection_amount,
            'charge_amount'=>$charge_amount,
            'total_collection'=>$total_collection,
        );
        parcel_account::insert($parcel_account_array);
    }
}
