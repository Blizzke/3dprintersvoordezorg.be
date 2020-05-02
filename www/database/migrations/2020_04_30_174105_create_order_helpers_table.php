<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHelpersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_helpers', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->unsigned();
            $table->integer('helper_id')->unsigned();
            $table->tinyInteger('approved')->default(0);
            $table->integer('quantity')->nullable();
            $table->longText('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_helpers');
    }
}
