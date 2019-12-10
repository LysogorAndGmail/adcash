<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SalesActivityType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_activity_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('org_id', false)->nullable();
            $table->foreign('org_id')->references('id')->on('organizations');
            $table->string('name')->nullable();
            $table->json('roles')->nullable();
            $table->tinyInteger('show_address', false)->nullable();
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
        Schema::dropIfExists('sales_activity_types');
    }
}
