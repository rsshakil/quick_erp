<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(permissionsTableDataSeeder::class);
        $this->call(rolesTableDataSeeder::class);
        $this->call(roleHasPermissionsTableDataSeeder::class);
        $this->call(modelHasrolesTableDataSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(ThanaSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(MerchantSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ChargeListSeeder::class);
        $this->call(WeightPackageSeeder::class);
        $this->call(ChargePackageSeeder::class);
        $this->call(DeliveryOptionSeeder::class);
        $this->call(ParcelSeeder::class);
    }
}
