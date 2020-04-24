<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddCustomersGeolocation extends Migration
{
    public function up()
    {
        Schema::table('customers', function ($table) {
            $table->longText('geolocation')->nullable();
        });
    }

    public function down()
    {
        Schema::table('customers', function ($table) {
            $table->dropColumn('geolocation');
        });
    }
}
