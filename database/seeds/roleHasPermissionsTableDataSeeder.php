<?php
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class roleHasPermissionsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $role_super_admin = Role::findByName('Super Admin');
        $role_super_admin = Role::where('name','Payra Admin')->first();
        $permissions = Permission::all();
        $role_super_admin->givePermissionTo($permissions);

        // $role_admin = Role::findByName('Admin');
        $role_admin = Role::where('name','Merchant')->first();
        $role_admin->givePermissionTo('admin_home','dashboard_menu','dashboard_view','all_menu_show','add_parcel','all_parcels');

        // $role_user = Role::findByName('User');
        $role_user = Role::where('name','Hub')->first();
        $role_user->givePermissionTo('admin_home','dashboard_menu','dashboard_view','personal_profile_view','personal_user_update','personal_password_change','all_menu_show',
    'hub_users',
    'add_hub_user',
    'edit_hub_user',
    );

        $pick_user = Role::where('name','Pick')->first();
        $pick_user->givePermissionTo('admin_home','dashboard_menu','dashboard_view','personal_profile_view','personal_user_update','personal_password_change','all_menu_show');

        $delivery_user = Role::where('name','Delivery')->first();
        $delivery_user->givePermissionTo('admin_home','dashboard_menu','dashboard_view','personal_profile_view','personal_user_update','personal_password_change','all_menu_show');

        $accounts_user = Role::where('name','Accounts')->first();
        $accounts_user->givePermissionTo('admin_home','dashboard_menu','dashboard_view','personal_profile_view','personal_user_update','personal_password_change','all_menu_show');
    }
}
