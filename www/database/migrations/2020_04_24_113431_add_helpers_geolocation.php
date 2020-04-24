<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddHelpersGeolocation extends Migration
{
    public function up()
    {
        Schema::table('helpers', function ($table) {
            $table->longText('geolocation')->nullable();
        });
    }

    public function down()
    {
        Schema::table('helpers', function ($table) {
            $table->dropColumn('geolocation');
        });
    }
}
