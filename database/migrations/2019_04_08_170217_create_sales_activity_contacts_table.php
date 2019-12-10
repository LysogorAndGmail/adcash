<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesActivityContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_activity_contacts', function (Blueprint $table) {
            $table->bigInteger('activity_id',false,true)->nullable();
            $table->foreign('activity_id')->references('id')->on('sales_activities')->onDelete('cascade');
            $table->bigInteger('contact_id',false,true)->nullable();
            $table->foreign('contact_id')->references('id')->on('company_contacts')->onDelete('cascade');
            $table->timestamps();
            
            $table->primary(['activity_id', 'contact_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_activity_contacts');
    }
}
