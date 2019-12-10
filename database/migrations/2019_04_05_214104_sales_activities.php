<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id',false,true);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->bigInteger('type_id', false, true);
            $table->foreign('type_id')->references('id')->on('sales_activity_types');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('address')->nullable();
            $table->text('info')->nullable();
            $table->text('result')->nullable();
            $table->tinyInteger('outcome', false)->nullable();
            $table->bigInteger('created_by',false, true)->nullable();
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
        Schema::dropIfExists('sales_activities');
    }
}
