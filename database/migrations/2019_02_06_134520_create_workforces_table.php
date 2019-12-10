<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkforcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workforces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('org_id')->unsigned();
            $table->foreign('org_id')->references('id')->on('organizations');
            $table->bigInteger('job_title_id')->unsigned();
            $table->foreign('job_title_id')->references('id')->on('job_titles');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('fname');
            $table->string('lname');
            $table->boolean('gender')->default(0);
            $table->string('idcode')->nullable();
            $table->date('dob');
            $table->boolean('is_personnel');
            $table->string('phone');
            $table->string('email');
            $table->string('address')->nullable();
            $table->string('bank_acc')->nullable();
            $table->string('source')->nullable();
            $table->bigInteger('recruited_by')->unsigned()->nullable();
            $table->foreign('recruited_by')->references('id')->on('users');
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workforces');
    }
}
