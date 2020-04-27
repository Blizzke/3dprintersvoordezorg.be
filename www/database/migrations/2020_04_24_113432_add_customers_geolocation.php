<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomersGeolocation extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->longText('geolocation')->nullable();
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('geolocation');
        });
    }
}
