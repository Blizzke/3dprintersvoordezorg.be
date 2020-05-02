<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrdersOptions extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->longText('options')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('options');
        });
    }
}
