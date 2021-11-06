<?php
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\ADMIN\User;
class modelHasrolesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user_super = User::findOrFail($this->user_search('Payra Super Admin'));
        $user_super->assignRole('Payra Admin');

        $user_merchant = User::findOrFail($this->user_search('Merchant'));
        $user_merchant->assignRole('Merchant');

        $user_hub = User::findOrFail($this->user_search('Hub'));
        $user_hub->assignRole('Hub');

        $user_pick = User::findOrFail($this->user_search('Pick'));
        $user_pick->assignRole('Pick');

        $user_delivery = User::findOrFail($this->user_search('Delivery'));
        $user_delivery->assignRole('Delivery');

        $user_accounts = User::findOrFail($this->user_search('Accounts'));
        $user_accounts->assignRole('Accounts');

    }
    private function user_search($user_name){
        $user_info=User::where('name',$user_name)->first();
        return $user_id=$user_info['id'];
    }
}
