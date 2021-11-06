<?php
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ADMIN\User;
use App\Models\ADMIN\users_details;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_array=array(
            [
                'name' => 'Payra Super Admin',
                'email' => 'super_admin@payra.com',
                'password' => bcrypt('Qe75ymSr')
            ],
            [
                'name' => 'Merchant',
                'email' => 'merchant@payra.com',
                'password' => bcrypt('Qe75ymSr')
            ],
            [
                'name' => 'Hub',
                'email' => 'hub@payra.com',
                'password' => bcrypt('Qe75ymSr')
            ],
            [
                'name' => 'Pick',
                'email' => 'pick@payra.com',
                'password' => bcrypt('Qe75ymSr')
            ],
            [
                'name' => 'Delivery',
                'email' => 'delivery@payra.com',
                'password' => bcrypt('Qe75ymSr')
            ],
            [
                'name' => 'Accounts',
                'email' => 'accounts@payra.com',
                'password' => bcrypt('Qe75ymSr')
            ]
        );


        $user_details_array=array(
            ['user_id'=>1],
            ['user_id'=>2],
            ['user_id'=>3],
            ['user_id'=>4],
            ['user_id'=>5],
            ['user_id'=>6],
        );
        User::insert($user_array);
        users_details::insert($user_details_array);

    }
}
