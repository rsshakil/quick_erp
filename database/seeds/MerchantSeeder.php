<?php

use Illuminate\Database\Seeder;
use App\Models\MERCHANT\merchant;
use App\Models\ADMIN\User;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $merchant_array=array(
            [
                'district_id' => 1,
                'thana_id'=>1,
                'area_id'=>1,
                'user_id'=>2,
                'company_name'=>'Software Solution',
                'full_address'=>'222/C Tejkunipara, Tejgaon, Dhaka',
                'business_address'=>'222/C Tejkunipara, Tejgaon, Dhaka',
                'phone'=>'01670514306',
                'facebook'=>'https://www.facebook.com/softwareSolution',
                'website'=>'https://www.software-solutionbd.com',
                'bank_name'=>'Islami Bank Bangladesh Limited',
                'account_holder_name'=>'Md. Mayeen Uddin',
                'account_number'=>'20501260203995004',
                'bkash_number'=>'01670514306',
                'nagad_number'=>'01670514306',
                'rocket_number'=>'01670514306',
                'status'=>'active',
            ],
        );
        merchant::insert($merchant_array);
        //User::where('id',2)->delete();
    }
}
