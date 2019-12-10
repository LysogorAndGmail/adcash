<?php

use Illuminate\Database\Seeder;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('job_titles')->truncate();
        DB::table('job_title_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(App\JobTitleCategory::class, 5)->create()->each(function ($category) {
            $category->jobTitles()->save(factory(App\JobTitle::class)->make());
        });
    }
}
