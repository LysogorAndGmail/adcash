<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToSalesActivityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_activity_types', function (Blueprint $table) {
            $table->bigInteger('created_by', false, true)->nullable()->after('show_address');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_activity_types', function (Blueprint $table) {
            $table->dropForeign('created_by');
            $table->dropColumn('created_by');
        });
    }
}
