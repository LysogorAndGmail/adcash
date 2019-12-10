<?php

use Illuminate\Database\Seeder;

class WorkforcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('workforces')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach (App\Organization::all() as $org) {
            factory(App\Workforce::class, 5)->create([
                'org_id'       => $org->id,
                'job_title_id' => factory(App\JobTitle::class)->create([
                    'category_id' => factory(App\JobTitleCategory::class)->create()
                ]),
                'created_by'   => factory(App\User::class)->create()
            ]);
        }
    }
}
