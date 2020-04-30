<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddHelpersChatName extends Migration
{
    public function up()
    {
        Schema::table('helpers', function ($table) {
            $table->string('chat_name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('helpers', function ($table) {
            $table->dropColumn('chat_name');
        });
    }
}
