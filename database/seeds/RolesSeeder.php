<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach (App\Organization::all() as $org) {
            $role               = new \App\Role();
            $role->org_id       = $org->id;
            $role->name         = 'manager';
            $role->display_name = 'Manager';
            $role->save();
            $role               = new \App\Role();
            $role->org_id       = $org->id;
            $role->name         = 'user';
            $role->display_name = 'User';
            $role->save();
        }
    }
}
