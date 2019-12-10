<?php

use Illuminate\Database\Seeder;

class ManagerPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $managers = \App\Role::where('name', 'manager')->get();
        foreach ($managers as $manager) {
            $manager->permissions()->attach(\App\Permission::all()->pluck('id'));
        }
    }
}
