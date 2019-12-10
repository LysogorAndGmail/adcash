<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrgSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('org_id', false, true)->nullable();
            $table->foreign('org_id')->references('id')->on('organizations');
            $table->integer('status_length_days', false, false)->default('30');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    /**F
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_settings');
    }
}
