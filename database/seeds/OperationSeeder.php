<?php

use Illuminate\Database\Seeder;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('operations')->truncate();
        DB::table('sub_operations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(App\Operation::class, 5)->create()->each(function ($operation) {
            $operation->subOperations()->save(factory(App\SubOperation::class)->make());
        });
    }
}
