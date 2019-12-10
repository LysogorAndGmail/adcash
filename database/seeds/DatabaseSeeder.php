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

        $this->call([

	        CountriesTableSeeder::class,
	        JobTitleSeeder::class,
	        OperationSeeder::class,
	        CompanyStatusSeeder::class,
	        RolesSeeder::class,
	        PermissionSeeder::class,
            ManagerPermissionSeeder::class,
            WorkforcesSeeder::class,
            UsersTableSeeder::class,
    	]);
    }
}
