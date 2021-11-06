<?php
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class permissionsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_array=array(
            [
                'name' => 'role',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'role_view',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'role_create',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'role_update',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'role_delete',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'permission',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'permission_view',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'permission_create',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'permission_update',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'permission_delete',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'assign_role_to_user',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'assign_role_to_user_view',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'assign_role_to_user_update',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'assign_permission_to_user',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'assign_permission_to_user_view',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'assign_permission_to_user_update',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'users',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'users_view',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'user_profile_view',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'user_create',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'user_permission_view',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'user_update',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'change_password',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'user_delete',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'personal_profile_view',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'personal_user_update',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'personal_password_change',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'all_menu_show',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'dashboard_menu',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'admin_home',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'dashboard_view',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'merchants',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'add-merchant',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'edit-merchant',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'all_shops',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'add_parcel',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'all_parcels',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'charge_list',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'weight_list',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'charge_packages',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'delivery_options',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'hubs',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'add-hubs',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'edit-hubs',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'hub_users',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'add_hub_user',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'edit_hub_user',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
        );
        Permission::insert($permission_array);
    }
}
