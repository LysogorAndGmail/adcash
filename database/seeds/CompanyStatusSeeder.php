<?php

use Illuminate\Database\Seeder;

class CompanyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('company_statuses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach (App\Organization::all() as $org) {
            factory(App\CompanyStatus::class, 3)->create([
                'org_id' => $org->id
            ]);
        }
    }
}
