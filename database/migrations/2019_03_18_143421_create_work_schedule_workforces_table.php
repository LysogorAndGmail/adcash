<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkScheduleWorkforcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_schedule_workforces', function (Blueprint $table) {
            $table->bigInteger('work_schedule_id')->unsigned();
            $table->foreign('work_schedule_id')->references('id')->on('work_schedules')->onDelete('cascade');
            $table->bigInteger('workforce_id')->unsigned();
            $table->foreign('workforce_id')->references('id')->on('workforces')->onDelete('cascade');
            $table->timestamps();

            $table->primary(['work_schedule_id', 'workforce_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_schedule_workforces');
    }
}
