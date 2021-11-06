<?php
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
class rolesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_array=array(
            [
                'name' => 'Payra Admin',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'Merchant',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'Hub',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'Pick',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'Delivery',
                'guard_name' => 'web',
                'is_system' => 1,
            ],
            [
                'name' => 'Accounts',
                'guard_name' => 'web',
                'is_system' => 1,
            ]
        );

        Role::insert($role_array);
    }
}
